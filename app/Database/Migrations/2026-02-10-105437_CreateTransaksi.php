<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransaksi extends Migration
{
    public function up()
    {
    $this->forge->addField([
        'id_transaksi'      => ['type' => 'VARCHAR', 'constraint' => 10],
        'id_order'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
        'id_admin'          => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
        'tanggal_transaksi' => ['type' => 'DATE', 'null' => true],
        'waktu_transaksi'   => ['type' => 'TIME', 'null' => true],
        'metode_transaksi'  => ['type' => 'ENUM', 'constraint' => ['Cash', 'Transfer'], 'null' => true],
        'status_transaksi'  => ['type' => 'ENUM', 'constraint' => ['Selesai', 'Belum Bayar'], 'null' => true],
    ]);
    $this->forge->addKey('id_transaksi', true);
    $this->forge->addUniqueKey('id_order');
    // Relasi ke Order dan Admin
    $this->forge->addForeignKey('id_order', 'orders', 'id_order', '', '');
    $this->forge->addForeignKey('id_admin', 'admin', 'id_admin', '', 'UPDATE');
    $this->forge->createTable('transaksi', true);
    }

    public function down()
    {
    $this->forge->dropTable('transaksi', true);
    }
}
