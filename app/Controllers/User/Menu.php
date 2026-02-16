<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\MenuModel;

class Menu extends BaseController
{
    public function index()
    {
        $menuModel = new MenuModel();

        // 1. TANGKAP NOMOR MEJA DARI URL
        // Contoh: localhost:8080/?table=12
        $mejaDariUrl = $this->request->getGet('table');

        // 2. SIMPAN KE SESSION
        // Jika ada data di URL, update session. 
        // Jika tidak ada di URL, biarkan session yang lama (supaya kalau refresh gak hilang)
        if ($mejaDariUrl) {
            session()->set('table_number', $mejaDariUrl);
        }

        // 3. AMBIL DATA MENU (Logic Lama)
        try {
            $menus = $menuModel->select('menu.*, kategori.nama_kategori as nama_kategori')
                               ->join('kategori', 'kategori.id_kategori = menu.id_kategori', 'left')
                               ->where('menu.status_menu', 'tersedia')
                               ->orderBy('kategori.nama_kategori', 'ASC')
                               ->orderBy('menu.nama_menu', 'ASC')
                               ->findAll();
        } catch (\Exception $e) {
            $menus = $menuModel->where('status_menu', 'tersedia')->findAll();
        }

        $kategoriList = [];
        foreach ($menus as $m) {
            $catName = $m['nama_kategori'] ?? 'Lainnya'; 
            if (!in_array($catName, $kategoriList)) $kategoriList[] = $catName;
        }

        // 4. KIRIM NOMOR MEJA KE VIEW
        $data = [
            'menus'       => $menus,
            'kategori'    => $kategoriList,
            'tableNumber' => session()->get('table_number') // Ambil dari session
        ];

        return view('user/index', $data);
    }
}