<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/login', 'LoginController::index');
$routes->post('/login/auth', 'LoginController::auth');
$routes->get('/logout', 'LoginController::logout');

// Routes Admin (Grouping)
$routes->group('admin', function($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
});