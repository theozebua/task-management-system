<?php

declare(strict_types=1);

namespace Config;

use App\Controllers\Api\Auth\{LoginController, LogoutController, RegisterController};
use App\Controllers\Api\User\{ProfileController};

$routes = Services::routes();

// Setup
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// Routes
$routes->post('/api/login', LoginController::class . '::handle');
$routes->post('/api/register', RegisterController::class . '::handle');
$routes->post('/api/logout', LogoutController::class . '::handle');
$routes->get('/api/profile', ProfileController::class . '::handle');
