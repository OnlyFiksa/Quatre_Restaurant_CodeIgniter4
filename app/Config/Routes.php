<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =======================================================================
// 1. HALAMAN UTAMA (USER / PELANGGAN)
// =======================================================================
$routes->get('/', 'User\Menu::index');
$routes->post('order/process', 'User\Order::process');
$routes->get('order/success/(:any)', 'User\Order::success/$1');


// =======================================================================
// 2. AUTHENTICATION (LOGIN ADMIN/STAFF)
// =======================================================================
$routes->get('login', 'LoginController::index');       
$routes->post('login/auth', 'LoginController::auth');  
$routes->get('logout', 'LoginController::logout');     


// =======================================================================
// 3. GRUP ROUTE ADMIN (BACKEND)
// =======================================================================
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    
    // --- DASHBOARD ---
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->get('dashboard/chart-data', 'Admin\Dashboard::chartData');

    // --- KELOLA MENU (MAKANAN) ---
    $routes->get('menu', 'Admin\Menu::index');
    $routes->get('menu/tambah', 'Admin\Menu::create');
    $routes->post('menu/store', 'Admin\Menu::store');
    $routes->get('menu/edit/(:segment)', 'Admin\Menu::edit/$1');
    $routes->post('menu/update/(:segment)', 'Admin\Menu::update/$1');
    $routes->get('menu/hapus/(:segment)', 'Admin\Menu::delete/$1');

    // --- [BARU] KELOLA KATEGORI ---
    $routes->get('kategori', 'Admin\Kategori::index');
    $routes->get('kategori/tambah', 'Admin\Kategori::create');
    $routes->post('kategori/store', 'Admin\Kategori::store');
    $routes->get('kategori/edit/(:segment)', 'Admin\Kategori::edit/$1');
    $routes->post('kategori/update/(:segment)', 'Admin\Kategori::update/$1');
    $routes->get('kategori/hapus/(:segment)', 'Admin\Kategori::delete/$1');

    // --- [BARU] KELOLA MEJA ---
    $routes->get('meja', 'Admin\Meja::index');
    $routes->get('meja/tambah', 'Admin\Meja::create');
    $routes->post('meja/store', 'Admin\Meja::store');
    $routes->get('meja/edit/(:segment)', 'Admin\Meja::edit/$1');
    $routes->post('meja/update/(:segment)', 'Admin\Meja::update/$1');
    $routes->get('meja/hapus/(:segment)', 'Admin\Meja::delete/$1');

    // --- KELOLA STAFF (USER MANAGEMENT) ---
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/tambah', 'Admin\Users::create');
    $routes->post('users/store', 'Admin\Users::store');
    $routes->get('users/edit/(:segment)', 'Admin\Users::edit/$1');
    $routes->post('users/update/(:segment)', 'Admin\Users::update/$1');
    $routes->get('users/hapus/(:segment)', 'Admin\Users::delete/$1');

    // --- PESANAN MASUK (KASIR/DAPUR) ---
    $routes->get('pesanan', 'Admin\Pesanan::index');
    $routes->get('pesanan/detail/(:segment)', 'Admin\Pesanan::detail/$1');
    
    // --- TRANSAKSI (PEMBAYARAN) ---
    $routes->post('transaksi/proses', 'Admin\Transaksi::proses');

    // --- LAPORAN ---
    $routes->get('laporan', 'Admin\Laporan::index');

});


// =======================================================================
// 4. REST API ROUTES (MANUAL ROUTE)
// =======================================================================
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {

    // A. MASTER DATA
    // Menu
    $routes->get('menu', 'Menu::index');            
    $routes->get('menu/(:num)', 'Menu::show/$1');    
    $routes->post('menu', 'Menu::create');           
    $routes->put('menu/(:num)', 'Menu::update/$1');  
    $routes->delete('menu/(:num)', 'Menu::delete/$1');

    // Kategori
    $routes->get('kategori', 'Kategori::index');
    $routes->post('kategori', 'Kategori::create');
    $routes->put('kategori/(:num)', 'Kategori::update/$1');
    $routes->delete('kategori/(:num)', 'Kategori::delete/$1');

    // Meja
    $routes->get('meja', 'Meja::index');
    $routes->post('meja', 'Meja::create');
    $routes->put('meja/(:num)', 'Meja::update/$1');
    $routes->delete('meja/(:num)', 'Meja::delete/$1');

    // Admin
    $routes->get('admin', 'Admin::index');
    $routes->post('admin', 'Admin::create');
    $routes->put('admin/(:num)', 'Admin::update/$1');
    $routes->delete('admin/(:num)', 'Admin::delete/$1');

    // B. TRANSAKSI & ORDER
    $routes->get('order', 'Order::index');         
    $routes->post('order', 'Order::create');       

    $routes->get('transaksi', 'Transaksi::index');   
    $routes->post('transaksi', 'Transaksi::create'); 
    
    $routes->get('detail/(:any)', 'Detail::show/$1'); 
});