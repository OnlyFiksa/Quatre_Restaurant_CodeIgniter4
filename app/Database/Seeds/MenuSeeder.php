<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_menu' => 'menu002', 'id_kategori' => 'kat001', 
                'nama_menu' => 'Margherita Pizza', 'harga' => 33000.00, 
                'status_menu' => 'tersedia', 'gambar' => 'pizza.png', 'deskripsi' => ''
            ],
            [
                'id_menu' => 'menu003', 'id_kategori' => 'kat001', 
                'nama_menu' => 'Lasagna', 'harga' => 33000.00, 
                'status_menu' => 'tersedia', 'gambar' => 'lasagna.png', 'deskripsi' => ''
            ],
            [
                'id_menu' => 'menu006', 'id_kategori' => 'kat002', 
                'nama_menu' => 'Espresso', 'harga' => 15000.00, 
                'status_menu' => 'tersedia', 'gambar' => 'espresso.png', 'deskripsi' => 'Kopi mantap'
            ],
            [
                'id_menu' => 'menu007', 'id_kategori' => 'kat002', 
                'nama_menu' => 'Cappuccino', 'harga' => 15000.00, 
                'status_menu' => 'tersedia', 'gambar' => 'cappucino.png', 'deskripsi' => ''
            ],
        ];

        $this->db->table('menu')->insertBatch($data);
    }
}