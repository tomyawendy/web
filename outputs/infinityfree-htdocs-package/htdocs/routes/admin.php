<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SettingController;

$prefix = trim(config('app.admin_prefix', 'backstage'), '/');

$router->get("/{$prefix}/login", [AuthController::class, 'showLogin'], ['guest']);
$router->post("/{$prefix}/login", [AuthController::class, 'login'], ['guest']);
$router->post("/{$prefix}/logout", [AuthController::class, 'logout'], ['auth']);
$router->post("/{$prefix}/password", [AuthController::class, 'changePassword'], ['auth']);

$router->get("/{$prefix}", [DashboardController::class, 'index'], ['auth']);
$router->get("/{$prefix}/pages", [AdminPageController::class, 'index'], ['auth', 'permission:manage_pages']);
$router->get("/{$prefix}/pages/create", [AdminPageController::class, 'create'], ['auth', 'permission:manage_pages']);
$router->post("/{$prefix}/pages/save", [AdminPageController::class, 'save'], ['auth', 'permission:manage_pages']);
$router->get("/{$prefix}/pages/{id}", [AdminPageController::class, 'edit'], ['auth', 'permission:manage_pages']);

$router->get("/{$prefix}/services", [AdminServiceController::class, 'index'], ['auth', 'permission:manage_services']);
$router->get("/{$prefix}/services/create", [AdminServiceController::class, 'create'], ['auth', 'permission:manage_services']);
$router->post("/{$prefix}/services/save", [AdminServiceController::class, 'save'], ['auth', 'permission:manage_services']);
$router->get("/{$prefix}/services/{id}", [AdminServiceController::class, 'edit'], ['auth', 'permission:manage_services']);

$router->get("/{$prefix}/posts", [AdminPostController::class, 'index'], ['auth', 'permission:manage_posts']);
$router->get("/{$prefix}/posts/create", [AdminPostController::class, 'create'], ['auth', 'permission:manage_posts']);
$router->post("/{$prefix}/posts/save", [AdminPostController::class, 'save'], ['auth', 'permission:manage_posts']);
$router->get("/{$prefix}/posts/{id}", [AdminPostController::class, 'edit'], ['auth', 'permission:manage_posts']);

$router->get("/{$prefix}/banners", [BannerController::class, 'index'], ['auth', 'permission:manage_banners']);
$router->get("/{$prefix}/banners/create", [BannerController::class, 'create'], ['auth', 'permission:manage_banners']);
$router->post("/{$prefix}/banners/save", [BannerController::class, 'save'], ['auth', 'permission:manage_banners']);
$router->get("/{$prefix}/banners/{id}", [BannerController::class, 'edit'], ['auth', 'permission:manage_banners']);

$router->get("/{$prefix}/settings", [SettingController::class, 'edit'], ['auth', 'permission:manage_settings']);
$router->post("/{$prefix}/settings", [SettingController::class, 'save'], ['auth', 'permission:manage_settings']);

$router->get("/{$prefix}/media", [MediaController::class, 'index'], ['auth', 'permission:manage_media']);
$router->post("/{$prefix}/media/upload", [MediaController::class, 'upload'], ['auth', 'permission:manage_media']);
$router->get("/{$prefix}/contacts", [AdminContactController::class, 'index'], ['auth', 'permission:view_contacts']);
$router->get("/{$prefix}/newsletters", [AdminNewsletterController::class, 'index'], ['auth', 'permission:view_newsletters']);
$router->get("/{$prefix}/admins", [AdminController::class, 'index'], ['auth', 'permission:manage_admins']);
$router->get("/{$prefix}/admins/create", [AdminController::class, 'create'], ['auth', 'permission:manage_admins']);
$router->post("/{$prefix}/admins/save", [AdminController::class, 'save'], ['auth', 'permission:manage_admins']);
