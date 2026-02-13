<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrders extends Migration
{
    public function up()
    {
    $this->forge->addField([
        'id_order'      => ['type' => 'VARCHAR', 'constraint' => 100],
        'id_meja'       => ['type' => 'VARCHAR', 'constraint' => 10],
        'nama_customer' => ['type' => 'VARCHAR', 'constraint' => 100],
        'nomor_telepon' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
        'tanggal_order' => ['type' => 'DATE'],
        'waktu_order'   => ['type' => 'TIME'],
        'total_harga'   => ['type' => 'DECIMAL', 'constraint' => '10,2'],
        'status_order'  => ['type' => 'ENUM', 'constraint' => ['selesai', 'proses'], 'default' => 'proses'],
    ]);
    $this->forge->addKey('id_order', true);
    // Relasi ke tabel Meja
    $this->forge->addForeignKey('id_meja', 'meja', 'id_meja', 'CASCADE', 'UPDATE');
    $this->forge->createTable('orders', true);
    }

    public function down()
    {
    $this->forge->dropTable('orders', true);
    }
}
