<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | CMS Portofolio</title>
    
    <!-- Google Fonts: Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (CDN for Login) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="flex flex-col min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
        
        <!-- Header / Logo -->
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold tracking-tight text-slate-900 font-heading">
                CMS Portofolio
            </h2>
            <p class="mt-2 text-sm text-slate-600">
                Masuk ke panel manajemen konten admin
            </p>
        </div>

        <!-- Login Card -->
        <div class="bg-white py-8 px-6 shadow-md rounded-2xl border border-slate-200">
            <!-- Flash Message -->
            <?php if (session_has_flash('error')): ?>
                <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 flex items-center gap-2 text-sm">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-red-600 flex-shrink-0"></i>
                    <span><?= e(session_flash('error')) ?></span>
                </div>
            <?php endif; ?>

            <?php if (session_has_flash('success')): ?>
                <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 flex items-center gap-2 text-sm">
                    <i data-lucide="check-circle" class="w-4 h-4 text-green-600 flex-shrink-0"></i>
                    <span><?= e(session_flash('success')) ?></span>
                </div>
            <?php endif; ?>

            <form class="space-y-6" action="/admin/login" method="POST">
                <?= csrf_field() ?>

                <!-- Honeypot anti-spam (invisible) -->
                <div class="hidden">
                    <input type="text" name="username_hp" value="">
                </div>

                <div>
                    <label for="email" class="block text-sm font-bold text-slate-700">Email / Username</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="mail" class="h-4 h-4 text-slate-400"></i>
                        </div>
                        <input type="text" name="email" id="email" required value="<?= e(old('email')) ?>"
                            class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                            placeholder="nama@email.com">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-slate-700">Kata Sandi</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="h-4 h-4 text-slate-400"></i>
                        </div>
                        <input type="password" name="password" id="password" required
                            class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="text-xs">
                        <a href="<?= route('/') ?>" class="font-medium text-slate-600 hover:text-slate-900 flex items-center gap-1.5">
                            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali ke Website
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit" id="submit-btn"
                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors gap-2 items-center">
                        <i data-lucide="log-in" class="w-4 h-4"></i> Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script to handle loading state and render icons -->
    <script>
        lucide.createIcons();

        // Loading state representation
        const form = document.querySelector('form');
        const submitBtn = document.getElementById('submit-btn');

        if (form && submitBtn) {
            form.addEventListener('submit', () => {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="inline-block animate-spin border-2 border-white border-t-transparent rounded-full w-4 h-4"></span> Memproses...';
            });
        }
    </script>
</body>
</html>
