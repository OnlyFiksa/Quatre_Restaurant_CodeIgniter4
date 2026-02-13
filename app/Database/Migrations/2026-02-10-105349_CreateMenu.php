<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenu extends Migration
{
    public function up()
    {
    $this->forge->addField([
        'id_menu'     => ['type' => 'VARCHAR', 'constraint' => 10],
        'id_kategori' => ['type' => 'VARCHAR', 'constraint' => 10],
        'nama_menu'   => ['type' => 'VARCHAR', 'constraint' => 100],
        'harga'       => ['type' => 'DECIMAL', 'constraint' => '10,2'],
        'status_menu' => ['type' => 'ENUM', 'constraint' => ['tersedia', 'tidak tersedia'], 'default' => 'tersedia'],
        'gambar'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        'deskripsi'   => ['type' => 'TEXT', 'null' => true],
        'created_at'  => ['type' => 'TIMESTAMP', 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
    ]);
    $this->forge->addKey('id_menu', true);
    // Relasi ke tabel Kategori
    $this->forge->addForeignKey('id_kategori', 'kategori', 'id_kategori', 'CASCADE', 'UPDATE');
    $this->forge->createTable('menu', true);
    }

    public function down()
    {
    $this->forge->dropTable('menu', true);
    }
}
