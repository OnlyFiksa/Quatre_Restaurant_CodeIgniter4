<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdmin extends Migration
{
    public function up()
    {
    $this->forge->addField([
        'id_admin' => ['type' => 'VARCHAR', 'constraint' => 10],
        'nama'     => ['type' => 'VARCHAR', 'constraint' => 100],
        'email'    => ['type' => 'VARCHAR', 'constraint' => 100],
        'username' => ['type' => 'VARCHAR', 'constraint' => 50],
        'password' => ['type' => 'VARCHAR', 'constraint' => 255],
        'jabatan'  => ['type' => 'ENUM', 'constraint' => ['Owner', 'Supervisor', 'Staff'], 'default'    => 'Staff',
    ],
    ]);
    $this->forge->addKey('id_admin', true);
    $this->forge->addUniqueKey('username');
    $this->forge->createTable('admin', true);
    }

    public function down()
    {
    $this->forge->dropTable('admin', true);
    }
}
