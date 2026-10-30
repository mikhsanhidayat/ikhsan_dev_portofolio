<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Controllers\AdminSettingController;
use App\Controllers\AuthController;
use App\Core\Database;
use App\Services\PasswordPolicy;
use App\Services\RateLimiter;

final class FixturePDO extends PDO
{
    public string $hash;
    public bool $transaction = false;
    public bool $locked = false;
    public ?string $replacement = null;
    public bool $failUpdate = false;
    public array $settings = [];

    public function __construct() {}
    public function beginTransaction(): bool { $this->transaction = true; return true; }
    public function inTransaction(): bool { return $this->transaction; }
    public function commit(): bool { $this->transaction = false; return true; }
    public function rollBack(): bool { $this->transaction = false; return true; }
    public function prepare(string $query, array $options = []): PDOStatement|false
    {
        return new FixtureStatement($this, $query);
    }
}

final class FixtureStatement extends PDOStatement
{
    public function __construct(private FixturePDO $db, private string $query) {}
    public function execute(?array $params = null): bool
    {
        if (str_contains($this->query, 'FOR UPDATE')) {
            ensure($this->db->transaction, 'lock inside transaction');
            ensure($params === [7], 'session account only');
            $this->db->locked = true;
            if ($this->db->replacement !== null) {
                $this->db->hash = $this->db->replacement;
                $this->db->replacement = null;
            }
        } elseif (str_contains($this->query, 'SET `password`')) {
            ensure($this->db->locked && $this->db->transaction, 'update under lock');
            if ($this->db->failUpdate) {
                throw new RuntimeException('fixture failure');
            }
            ensure($params[1] === 7, 'update session account');
            $this->db->hash = $params[0];
        } elseif (str_contains($this->query, 'UPDATE `settings`')) {
            $this->db->settings[$params[1]] = $params[0];
        }
        return true;
    }
    public function fetch(int $mode = PDO::FETCH_DEFAULT, int $cursorOrientation = PDO::FETCH_ORI_NEXT, int $cursorOffset = 0): mixed
    {
        return ['id' => 7, 'name' => 'Fixture', 'email' => 'fixture@example.test', 'password' => $this->db->hash];
    }
}

final class Redirected extends Error {}
final class SettingsFixture extends AdminSettingController
{
    public string $location = '';
    protected function redirect(string $url): void { $this->location = $url; }
}
final class LoginFixture extends AuthController
{
    public string $location = '';
    protected function redirect(string $url): void { $this->location = $url; throw new Redirected(); }
}

function ensure(bool $condition, string $label): void
{
    if (!$condition) {
        throw new RuntimeException('FAIL: ' . $label);
    }
}

$dir = sys_get_temp_dir() . '/password-tests-' . bin2hex(random_bytes(8));
mkdir($dir, 0700);
ini_set('session.save_path', $dir);
session_start();
$db = new FixturePDO();
(new ReflectionProperty(Database::class, 'instance'))->setValue(null, $db);
(new ReflectionProperty(RateLimiter::class, 'passwordFilePath'))->setValue(null, $dir . '/password.json');
(new ReflectionProperty(RateLimiter::class, 'filePath'))->setValue(null, $dir . '/login.json');
$_SERVER['REMOTE_ADDR'] = '192.0.2.1';
$old = 'Original password 123';
$new = 'Replacement password 456';
$originalHash = password_hash($old, PASSWORD_BCRYPT);
$controller = new SettingsFixture();
$reset = function () use ($db, $originalHash, $dir, $old, $new, $controller): void {
    if (is_file($dir . '/password.json')) { unlink($dir . '/password.json'); }
    $db->hash = $originalHash;
    $db->locked = false;
    $db->failUpdate = false;
    $controller->location = '';
    http_response_code(200);
    $_SESSION = ['admin_logged_in' => true, 'admin_id' => 7, 'csrf_token' => 'fixture-token'];
    $_POST = ['csrf_token' => 'fixture-token', 'current_password' => $old, 'new_password' => $new, 'confirm_password' => $new, 'admin_id' => 99];
};

try {
    foreach ([str_repeat('a', 11) => false, str_repeat('a', 12) => true, str_repeat('a', 72) => true, str_repeat('a', 73) => false, str_repeat('é', 12) => true, str_repeat('é', 37) => false, "invalid\xfftext12345" => false, "null\0password123" => false] as $value => $valid) {
        ensure(PasswordPolicy::valid($value) === $valid, 'policy boundary');
    }
    ensure(!PasswordPolicy::valid([]), 'policy type');
    foreach (['wrong', 'short', 'long', 'mismatch', 'same', 'array', 'csrf', 'csrf-session', 'guest', 'missing-id', 'race', 'failure'] as $case) {
        $reset();
        switch ($case) {
            case 'wrong': $_POST['current_password'] = 'wrong'; break;
            case 'short': $_POST['new_password'] = $_POST['confirm_password'] = str_repeat('a', 11); break;
            case 'long': $_POST['new_password'] = $_POST['confirm_password'] = str_repeat('a', 73); break;
            case 'mismatch': $_POST['confirm_password'] .= ' '; break;
            case 'same': $_POST['new_password'] = $_POST['confirm_password'] = $old; break;
            case 'array': $_POST['current_password'] = []; break;
            case 'csrf': $_POST['csrf_token'] = []; break;
            case 'csrf-session': $_SESSION['csrf_token'] = []; break;
            case 'guest': $_SESSION = []; break;
            case 'missing-id': unset($_SESSION['admin_id']); break;
            case 'race': $db->replacement = password_hash('Concurrent replacement', PASSWORD_BCRYPT); break;
            case 'failure': $db->failUpdate = true; break;
        }
        ob_start();
        $controller->password();
        $body = ob_get_clean();
        ensure(!password_verify($new, $db->hash), $case . ' rejected');
        ensure(!$db->inTransaction(), $case . ' transaction closed');
        if (str_starts_with($case, 'csrf')) { ensure(http_response_code() === 403 && !$db->locked, 'csrf before database'); }
        if (in_array($case, ['guest', 'missing-id'], true)) { ensure($controller->location === '/admin/login', 'unauthenticated'); }
        ensure(!str_contains(serialize($_SESSION), $old) && !str_contains($body, $new), 'no password retention');
    }
    $reset();
    for ($i = 0; $i < 5; $i++) { ensure(RateLimiter::consumePasswordAttempt(7, '192.0.2.2'), 'account allowance'); }
    $controller->password();
    ensure($db->hash === $originalHash && !$db->locked, 'account limit across IPs');
    $reset();
    for ($i = 1; $i <= 20; $i++) { ensure(RateLimiter::consumePasswordAttempt($i, '192.0.2.3'), 'IP allowance'); }
    ensure(!RateLimiter::consumePasswordAttempt(21, '192.0.2.3'), 'IP limit across accounts');
    $reset();
    file_put_contents($dir . '/password.json', json_encode(['account_7' => ['attempts' => 5, 'expires' => time() - 1]]));
    ensure(RateLimiter::consumePasswordAttempt(7, '192.0.2.1'), 'expired limiter');
    file_put_contents($dir . '/password.json', '{broken');
    $controller->password();
    ensure($db->hash === $originalHash && !$db->locked, 'corrupt limiter fails closed');
    ensure(RateLimiter::check('fixture-login', 2), 'login limiter initial');
    RateLimiter::hit('fixture-login');
    ensure(RateLimiter::check('fixture-login', 2), 'login limiter first hit');
    RateLimiter::hit('fixture-login');
    ensure(!RateLimiter::check('fixture-login', 2), 'login limiter unchanged');
    RateLimiter::clear('fixture-login');
    ensure(RateLimiter::check('fixture-login', 2), 'login limiter clear');
    $reset();
    $oldSession = session_id();
    $controller->password();
    ensure(password_verify($new, $db->hash) && !password_verify($old, $db->hash), 'new hash');
    ensure(password_get_info($db->hash)['algoName'] === 'bcrypt', 'bcrypt');
    ensure(session_id() !== $oldSession && !is_file($dir . '/sess_' . $oldSession), 'old session destroyed');
    ensure(array_keys($_SESSION) === ['flash'] && $controller->location === '/admin/login', 'fresh anonymous session');
    foreach ([$old => '/admin/login', $new => '/admin/dashboard'] as $password => $target) {
        $_SESSION = ['csrf_token' => 'fixture-token'];
        $_POST = ['csrf_token' => 'fixture-token', 'email' => 'fixture@example.test', 'password' => $password];
        $login = new LoginFixture();
        try { $login->login(); } catch (Redirected $e) {}
        ensure($login->location === $target, 'login old/new');
    }
    $reset();
    $_POST += ['website_name' => 'Fixture', 'meta_title' => 'Title', 'meta_description' => 'Description', 'footer_text' => 'Footer', 'primary_color' => 'blue', 'google_maps_link' => 'Location'];
    $controller->update();
    ensure(count($db->settings) === 6 && $db->hash === $originalHash, 'website settings unchanged');
    foreach ([str_repeat('é', 12), str_repeat('a', 72), '  exact spaces  '] as $value) {
        $reset();
        $_POST['new_password'] = $_POST['confirm_password'] = $value;
        $controller->password();
        ensure(password_verify($value, $db->hash), 'accepted boundary without trim');
    }
    $reset();
    if (function_exists('pcntl_fork')) {
        session_write_close();
        $children = [];
        for ($i = 0; $i < 16; $i++) {
            $pid = pcntl_fork();
            if ($pid === 0) { exit(RateLimiter::consumePasswordAttempt(7, '192.0.2.' . ($i + 10)) ? 0 : 2); }
            ensure($pid > 0, 'fork');
            $children[] = $pid;
        }
        $allowed = 0;
        foreach ($children as $pid) {
            pcntl_waitpid($pid, $status);
            ensure(pcntl_wifexited($status), 'child exited');
            $code = pcntl_wexitstatus($status);
            ensure(in_array($code, [0, 2], true), 'child result');
            $allowed += $code === 0 ? 1 : 0;
        }
        ensure($allowed === 5, 'atomic limiter across processes');
        echo "PASS: 16-process limiter race (exactly 5 allowed)\n";
    } else {
        echo "SKIP: pcntl unavailable; limiter concurrency not executed\n";
    }
    echo "PASS: policy, controller, CSRF, auth, throttling, mocked latest-hash race/rollback, login, settings, session destruction\n";
} finally {
    if (session_status() === PHP_SESSION_ACTIVE) { $_SESSION = []; session_destroy(); }
    foreach (glob($dir . '/*') as $file) { unlink($file); }
    rmdir($dir);
}
