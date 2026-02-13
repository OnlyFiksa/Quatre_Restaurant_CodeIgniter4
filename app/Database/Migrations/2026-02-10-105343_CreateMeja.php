<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMeja extends Migration
{
    public function up()
    {
    $this->forge->addField([
        'id_meja'     => ['type' => 'VARCHAR', 'constraint' => 10],
        'nomor_meja'  => ['type' => 'INT', 'constraint' => 11],
        'status_meja' => ['type' => 'ENUM', 'constraint' => ['tersedia', 'tidak tersedia'], 'default' => 'tersedia'],
    ]);
    $this->forge->addKey('id_meja', true);
    $this->forge->createTable('meja', true);
    }

    public function down()
    {
    $this->forge->dropTable('meja', true);
    }
}
