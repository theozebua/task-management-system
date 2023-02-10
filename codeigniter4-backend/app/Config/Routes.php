<?php

declare(strict_types=1);

namespace Config;

$routes = Services::routes();

// Setup
$routes->setTranslateURIDashes(false);
$routes->set404Override();

$apiNamespace = \App\Controllers\Api::class;
$apiPrefix    = '/api/';

// Routes
$routes->group($apiPrefix, ['namespace' => "{$apiNamespace}\Auth"], static function () use ($routes) {
    $routes->post('login', 'LoginController::handle');
    $routes->post('register', 'RegisterController::handle');
    $routes->post('logout', 'LogoutController::handle', ['filter' => 'validatetoken']);
});

$routes->group($apiPrefix, ['namespace' => "{$apiNamespace}\User", 'filter' => 'validatetoken'], static function () use ($routes) {
    $routes->get('profile', 'ProfileController::handle');
    $routes->put('change-password', 'ChangePasswordController::handle');
});
