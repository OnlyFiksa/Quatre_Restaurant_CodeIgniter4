<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MenuModel;

class Menu extends BaseController
{
    protected $menuModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
    }

    public function index()
    {
        $data = [
            'menus' => $this->menuModel->findAll()
        ];
        return view('admin/menu/index', $data);
    }

    public function create()
    {
        return view('admin/menu/form', ['mode' => 'tambah']);
    }

    public function store()
    {
        // Handle Upload Gambar
        $fileGambar = $this->request->getFile('gambar');
        
        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('assets/image', $namaGambar); // Pindah ke public/assets/image
        } else {
            $namaGambar = 'default.jpg';
        }

        // Generate ID Menu (menu + 3 angka acak)
        $id_menu = 'menu' . rand(100, 999);

        $this->menuModel->insert([
            'id_menu'     => $id_menu,
            'id_kategori' => $this->request->getPost('id_kategori'), // Sesuai DB Anda
            'nama_menu'   => $this->request->getPost('nama_menu'),
            'harga'       => $this->request->getPost('harga'),
            'status_menu' => $this->request->getPost('status_menu'),
            'gambar'      => $namaGambar,
            'deskripsi'   => $this->request->getPost('deskripsi')
        ]);

        return redirect()->to('/admin/menu')->with('sukses', 'Menu berhasil ditambahkan!');
    }

    public function edit($id)
    {
        return view('admin/menu/form', [
            'mode' => 'edit',
            'menu' => $this->menuModel->find($id)
        ]);
    }

    public function update($id)
    {
        $menuLama = $this->menuModel->find($id);
        
        $data = [
            'id_kategori' => $this->request->getPost('id_kategori'), // Sesuai DB Anda
            'nama_menu'   => $this->request->getPost('nama_menu'),
            'harga'       => $this->request->getPost('harga'),
            'status_menu' => $this->request->getPost('status_menu'),
            'deskripsi'   => $this->request->getPost('deskripsi')
        ];

        // Cek Gambar Baru
        $fileGambar = $this->request->getFile('gambar');
        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            if ($menuLama['gambar'] != 'default.jpg' && file_exists('assets/image/' . $menuLama['gambar'])) {
                unlink('assets/image/' . $menuLama['gambar']);
            }
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('assets/image', $namaGambar);
            $data['gambar'] = $namaGambar;
        }

        $this->menuModel->update($id, $data);
        return redirect()->to('/admin/menu')->with('sukses', 'Menu berhasil diperbarui!');
    }

    public function delete($id)
    {
        $menu = $this->menuModel->find($id);
        
        if ($menu['gambar'] != 'default.jpg' && file_exists('assets/image/' . $menu['gambar'])) {
            unlink('assets/image/' . $menu['gambar']);
        }

        $this->menuModel->delete($id);
        return redirect()->to('/admin/menu')->with('sukses', 'Menu dihapus!');
    }
}