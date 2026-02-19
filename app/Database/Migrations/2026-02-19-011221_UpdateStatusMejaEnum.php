<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateStatusMejaEnum extends Migration
{
    public function up()
    {
        // KITA UBAH KOLOM 'status_meja'
        // Menambahkan opsi 'terisi'
        $fields = [
            'status_meja' => [
                'name'       => 'status_meja', // Pastikan nama kolom tetap sama
                'type'       => 'ENUM',
                'constraint' => ['tersedia', 'terisi', 'tidak_tersedia'], 
                'default'    => 'tersedia',
                'null'       => false,
            ],
        ];

        // Ubah tabel 'meja'
        $this->forge->modifyColumn('meja', $fields);
    }

    public function down()
    {
        // ROLLBACK: Kembalikan ke opsi semula (tanpa 'terisi')
        $fields = [
            'status_meja' => [
                'name'       => 'status_meja',
                'type'       => 'ENUM',
                'constraint' => ['tersedia', 'tidak_tersedia'], 
                'default'    => 'tersedia',
                'null'       => false,
            ],
        ];

        $this->forge->modifyColumn('meja', $fields);
    }
}