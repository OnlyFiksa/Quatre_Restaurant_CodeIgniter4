<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MejaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id_meja' => 'tab001', 'nomor_meja' => 1, 'status_meja' => 'tersedia'],
            ['id_meja' => 'tab002', 'nomor_meja' => 2, 'status_meja' => 'tersedia'],
            ['id_meja' => 'tab003', 'nomor_meja' => 3, 'status_meja' => 'tersedia'],
            ['id_meja' => 'tab004', 'nomor_meja' => 4, 'status_meja' => 'tersedia'],
            ['id_meja' => 'tab005', 'nomor_meja' => 5, 'status_meja' => 'tersedia'],
        ];

        $this->db->table('meja')->insertBatch($data);
    }
}