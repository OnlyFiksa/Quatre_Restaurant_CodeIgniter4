<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKategori extends Migration
{
    public function up()
    {
    $this->forge->addField([
        'id_kategori'     => ['type' => 'VARCHAR', 'constraint' => 10],
        'nama_kategori'   => ['type' => 'VARCHAR', 'constraint' => 50],
        'status_kategori' => ['type' => 'ENUM', 'constraint' => ['tersedia', 'tidak tersedia'], 'default' => 'tersedia'],
    ]);
    $this->forge->addKey('id_kategori', true);
    $this->forge->createTable('kategori', true);
    }

    public function down()
    {
    $this->forge->dropTable('kategori', true);
    }
}
