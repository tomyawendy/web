<?php

use App\Http\Controllers\PublicSite\ContactController;
use App\Http\Controllers\PublicSite\HomeControllerV2;
use App\Http\Controllers\PublicSite\NewsletterController;
use App\Http\Controllers\PublicSite\PageController;
use App\Http\Controllers\PublicSite\PostController;
use App\Http\Controllers\PublicSite\ServiceController;

$router->get('/', [HomeControllerV2::class, 'index']);
$router->get('/about', [PageController::class, 'about']);
$router->get('/contact', [PageController::class, 'contact']);
$router->get('/services', [ServiceController::class, 'index']);
$router->get('/services/{slug}', [ServiceController::class, 'show']);
$router->get('/insights', [PostController::class, 'newsIndex']);
$router->get('/insights/{slug}', [PostController::class, 'showNews']);
$router->get('/news', [PostController::class, 'newsIndex']);
$router->get('/news/{slug}', [PostController::class, 'showNews']);
$router->get('/documents', [PostController::class, 'documentIndex']);
$router->get('/documents/{slug}', [PostController::class, 'showDocument']);
$router->post('/contact', [ContactController::class, 'submit']);
$router->post('/newsletter', [NewsletterController::class, 'subscribe']);
$router->get('/page/{slug}', [PageController::class, 'show']);
