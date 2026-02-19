<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\KategoriModel;
use App\Models\MejaModel;

class Menu extends BaseController
{
    public function index()
    {
        $menuModel = new MenuModel();
        $kategoriModel = new KategoriModel();
        $mejaModel = new MejaModel();

        // 1. Cek Parameter Table/Meja
        $no_meja = $this->request->getGet('table') ?? $this->request->getGet('meja');

        // 2. LOGIC CEK STATUS MEJA
        if ($no_meja) {
            $dataMeja = $mejaModel->where('nomor_meja', $no_meja)->first();

            if (!$dataMeja) {
                return view('user/error_akses', [
                    'title' => 'Meja Tidak Ditemukan',
                    'pesan' => "Nomor Meja <strong>$no_meja</strong> tidak terdaftar."
                ]);
            }

            if ($dataMeja['status_meja'] == 'tidak_tersedia') {
                return view('user/error_akses', [
                    'title' => 'Meja Tidak Tersedia',
                    'pesan' => "Mohon maaf, <strong>Meja $no_meja</strong> sedang tidak dapat digunakan. Silakan pilih meja lain."
                ]);
            }
        }

        // 3. Tampilkan Menu (FIXED: Tambah JOIN Kategori)
        $data = [
            'kategori' => $kategoriModel->where('status_kategori', 'tersedia')->findAll(),
            
            'menus'    => $menuModel->select('menu.*, kategori.nama_kategori')
                                    ->join('kategori', 'kategori.id_kategori = menu.id_kategori')
                                    ->where('status_menu', 'tersedia')
                                    // PERBAIKAN: Urutkan berdasarkan nama kategori, lalu nama menu
                                    ->orderBy('kategori.nama_kategori', 'ASC')
                                    ->orderBy('menu.nama_menu', 'ASC')
                                    ->findAll(),
            
            'tableNumber' => $no_meja 
        ];

        return view('user/index', $data);
    }
}