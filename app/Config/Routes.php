<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =======================================================================
// 1. HALAMAN UTAMA (USER / PELANGGAN)
// =======================================================================

// Halaman Menu (Tampilan Awal)
$routes->get('/', 'User\Menu::index');

// [PENTING] Route untuk memproses Checkout dari Javascript
// Ini jembatan antara Frontend (JS) dan Backend (Database)
$routes->post('order/process', 'User\Order::process');

// Halaman Sukses (Setelah Pesan)
$routes->get('order/success/(:any)', 'User\Order::success/$1');


// =======================================================================
// 2. AUTHENTICATION (LOGIN ADMIN/STAFF)
// =======================================================================
$routes->get('login', 'LoginController::index');       // Halaman Form Login
$routes->post('login/auth', 'LoginController::auth');  // Proses Cek Password
$routes->get('logout', 'LoginController::logout');     // Proses Logout


// =======================================================================
// 3. GRUP ROUTE ADMIN (BACKEND)
// =======================================================================
$routes->group('admin', function($routes) {
    
    // --- DASHBOARD ---
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // --- KELOLA MENU (MAKANAN) ---
    $routes->get('menu', 'Admin\Menu::index');
    $routes->get('menu/tambah', 'Admin\Menu::create');        // Form Tambah
    $routes->post('menu/store', 'Admin\Menu::store');         // Proses Simpan
    $routes->get('menu/edit/(:segment)', 'Admin\Menu::edit/$1');    // Form Edit
    $routes->post('menu/update/(:segment)', 'Admin\Menu::update/$1'); // Proses Update
    $routes->get('menu/hapus/(:segment)', 'Admin\Menu::delete/$1');   // Proses Hapus

    // --- KELOLA STAFF (USER MANAGEMENT) ---
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/tambah', 'Admin\Users::create');
    $routes->post('users/store', 'Admin\Users::store');
    $routes->get('users/edit/(:segment)', 'Admin\Users::edit/$1');
    $routes->post('users/update/(:segment)', 'Admin\Users::update/$1');
    $routes->get('users/hapus/(:segment)', 'Admin\Users::delete/$1');

    // --- PESANAN MASUK (KASIR/DAPUR) ---
    $routes->get('pesanan', 'Admin\Pesanan::index');
    $routes->get('pesanan/detail/(:segment)', 'Admin\Pesanan::detail/$1'); // Detail Pesanan
    
    // --- TRANSAKSI (PEMBAYARAN) ---
    $routes->post('transaksi/proses', 'Admin\Transaksi::proses');

    // --- LAPORAN ---
    $routes->get('laporan', 'Admin\Laporan::index');

});