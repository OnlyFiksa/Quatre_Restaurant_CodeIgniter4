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
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    
    // --- DASHBOARD ---
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->get('dashboard/chart-data', 'Admin\Dashboard::chartData');

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

// =======================================================================
// 4. REST API ROUTES (FINAL - MANUAL ROUTE)
// =======================================================================
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {

    // -------------------------------------------------------------------
    // A. MASTER DATA (CRUD)
    // -------------------------------------------------------------------

    // 1. API MENU (ID: Angka)
    $routes->get('menu', 'Menu::index');             // Lihat Semua
    $routes->get('menu/(:num)', 'Menu::show/$1');    // Lihat Satu
    $routes->post('menu', 'Menu::create');           // Tambah
    $routes->put('menu/(:num)', 'Menu::update/$1');  // Edit
    $routes->delete('menu/(:num)', 'Menu::delete/$1');// Hapus

    // 2. API KATEGORI (ID: Angka)
    $routes->get('kategori', 'Kategori::index');
    $routes->post('kategori', 'Kategori::create');
    $routes->put('kategori/(:num)', 'Kategori::update/$1');
    $routes->delete('kategori/(:num)', 'Kategori::delete/$1');

    // 3. API MEJA (ID: Angka)
    $routes->get('meja', 'Meja::index');
    $routes->post('meja', 'Meja::create');
    $routes->put('meja/(:num)', 'Meja::update/$1');
    $routes->delete('meja/(:num)', 'Meja::delete/$1');

    // 4. API ADMIN (ID: Angka)
    $routes->get('admin', 'Admin::index');
    $routes->post('admin', 'Admin::create');
    $routes->put('admin/(:num)', 'Admin::update/$1');
    $routes->delete('admin/(:num)', 'Admin::delete/$1');


    // -------------------------------------------------------------------
    // B. TRANSAKSI & ORDER (Flow Utama)
    // -------------------------------------------------------------------

    // 5. API ORDER (Pelanggan/Pelayan) - ID: String (ORD-...)
    // Fokus: Membuat pesanan status 'masuk'
    $routes->get('order', 'Order::index');           // Lihat order aktif
    $routes->post('order', 'Order::create');         // Buat order baru

    // 6. API TRANSAKSI (Kasir) - ID: String (TRX-...)
    // Fokus: Melakukan pembayaran & ubah status jadi 'selesai'
    $routes->get('transaksi', 'Transaksi::index');   // Lihat history pembayaran
    $routes->post('transaksi', 'Transaksi::create'); // POS BAYAR (Insert Transaksi + Update Order)
    
    // 7. API DETAIL ORDER
    $routes->get('detail/(:any)', 'Detail::show/$1'); // Lihat detail menu per Order ID
});