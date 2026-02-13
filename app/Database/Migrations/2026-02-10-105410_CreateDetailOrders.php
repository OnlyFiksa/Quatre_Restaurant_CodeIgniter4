<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDetailOrders extends Migration
{
    public function up()
    {
    $this->forge->addField([
        'id_detailorder' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
        'id_order'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
        'id_menu'        => ['type' => 'VARCHAR', 'constraint' => 10],
        'quantity'       => ['type' => 'INT', 'constraint' => 11],
        'subtotal'       => ['type' => 'DECIMAL', 'constraint' => '10,2'],
    ]);
    $this->forge->addKey('id_detailorder', true);
    // Dua Relasi Sekaligus
    $this->forge->addForeignKey('id_order', 'orders', 'id_order', '', '');
    $this->forge->addForeignKey('id_menu', 'menu', 'id_menu', '', 'UPDATE');
    $this->forge->createTable('detail_orders', true);
    }

    public function down()
    {
    $this->forge->dropTable('detail_orders', true);
    }
}
