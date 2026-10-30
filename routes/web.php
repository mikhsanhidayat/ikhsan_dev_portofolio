<?php

declare(strict_types=1);

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\AdminDashboardController;
use App\Controllers\AdminProfileController;
use App\Controllers\AdminSkillController;
use App\Controllers\AdminEducationController;
use App\Controllers\AdminExperienceController;
use App\Controllers\AdminCvController;
use App\Controllers\AdminCategoryController;
use App\Controllers\AdminTechnologyController;
use App\Controllers\AdminProjectController;
use App\Controllers\AdminInboxController;
use App\Controllers\AdminSettingController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

/** @var Router $router */

// Public Routes
$router->get('/', [HomeController::class, 'index']);
$router->post('/contact', [HomeController::class, 'submitContact']);
$router->get('/project/{slug}', [HomeController::class, 'projectDetail']);
$router->get('/sitemap.xml', [HomeController::class, 'sitemap']);

// Auth Routes (Guest Only)
$router->get('/admin/login', [AuthController::class, 'showLogin'], [GuestMiddleware::class]);
$router->post('/admin/login', [AuthController::class, 'login'], [GuestMiddleware::class]);
$router->post('/admin/logout', [AuthController::class, 'logout']);

// Admin Protected Routes
$router->group('/admin', [AuthMiddleware::class], function (Router $r) {
    $r->get('/dashboard', [AdminDashboardController::class, 'index']);
    
    // Profile Management
    $r->get('/profile', [AdminProfileController::class, 'index']);
    $r->post('/profile', [AdminProfileController::class, 'update']);
    
    // Skills Management
    $r->get('/skills', [AdminSkillController::class, 'index']);
    $r->post('/skills', [AdminSkillController::class, 'store']);
    $r->post('/skills/edit/{id}', [AdminSkillController::class, 'update']);
    $r->post('/skills/delete/{id}', [AdminSkillController::class, 'delete']);
    
    // Education Management
    $r->get('/education', [AdminEducationController::class, 'index']);
    $r->post('/education', [AdminEducationController::class, 'store']);
    $r->post('/education/edit/{id}', [AdminEducationController::class, 'update']);
    $r->post('/education/delete/{id}', [AdminEducationController::class, 'delete']);

    // Experience Management
    $r->get('/experience', [AdminExperienceController::class, 'index']);
    $r->post('/experience', [AdminExperienceController::class, 'store']);
    $r->post('/experience/edit/{id}', [AdminExperienceController::class, 'update']);
    $r->post('/experience/delete/{id}', [AdminExperienceController::class, 'delete']);

    // CV Management
    $r->get('/cv', [AdminCvController::class, 'index']);
    $r->post('/cv', [AdminCvController::class, 'upload']);
    $r->post('/cv/delete', [AdminCvController::class, 'delete']);

    // Categories Management
    $r->get('/categories', [AdminCategoryController::class, 'index']);
    $r->post('/categories', [AdminCategoryController::class, 'store']);
    $r->post('/categories/edit/{id}', [AdminCategoryController::class, 'update']);
    $r->post('/categories/delete/{id}', [AdminCategoryController::class, 'delete']);

    // Technologies Management
    $r->get('/technologies', [AdminTechnologyController::class, 'index']);
    $r->post('/technologies', [AdminTechnologyController::class, 'store']);
    $r->post('/technologies/edit/{id}', [AdminTechnologyController::class, 'update']);
    $r->post('/technologies/delete/{id}', [AdminTechnologyController::class, 'delete']);

    // Projects Management
    $r->get('/projects', [AdminProjectController::class, 'index']);
    $r->get('/projects/create', [AdminProjectController::class, 'create']);
    $r->post('/projects/create', [AdminProjectController::class, 'store']);
    $r->get('/projects/edit/{id}', [AdminProjectController::class, 'edit']);
    $r->post('/projects/edit/{id}', [AdminProjectController::class, 'update']);
    $r->post('/projects/delete/{id}', [AdminProjectController::class, 'delete']);

    // Project Gallery Management
    $r->get('/projects/gallery/{id}', [AdminProjectController::class, 'gallery']);
    $r->post('/projects/gallery/{id}', [AdminProjectController::class, 'storeGallery']);
    $r->post('/projects/gallery/edit/{id}', [AdminProjectController::class, 'updateGallery']);
    $r->post('/projects/gallery/delete/{id}', [AdminProjectController::class, 'deleteGallery']);

    // Inbox Management
    $r->get('/inbox', [AdminInboxController::class, 'index']);
    $r->get('/inbox/detail/{id}', [AdminInboxController::class, 'detail']);
    $r->post('/inbox/toggle-read/{id}', [AdminInboxController::class, 'toggleRead']);
    $r->post('/inbox/archive/{id}', [AdminInboxController::class, 'archive']);
    $r->post('/inbox/delete/{id}', [AdminInboxController::class, 'delete']);

    // Settings Management
    $r->get('/settings', [AdminSettingController::class, 'index']);
    $r->post('/settings', [AdminSettingController::class, 'update']);
    $r->post('/settings/password', [AdminSettingController::class, 'password']);
});
