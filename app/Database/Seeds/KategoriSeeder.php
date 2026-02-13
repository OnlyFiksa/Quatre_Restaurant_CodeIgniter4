<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id_kategori' => 'kat001', 'nama_kategori' => 'makanan', 'status_kategori' => 'tersedia'],
            ['id_kategori' => 'kat002', 'nama_kategori' => 'minuman', 'status_kategori' => 'tersedia'],
        ];

        $this->db->table('kategori')->insertBatch($data);
    }
}