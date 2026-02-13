<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_admin' => 'ad262', 
                'nama' => 'Asep', 
                'email' => 'asep@gmail.com',
                'username' => 'aassep', 'password' => password_hash('12345', PASSWORD_DEFAULT),
                'jabatan' => 'Staff' 
            ],
            [
                'id_admin' => 'ad397', 'nama' => 'Taufik', 'email' => 'taufik@gmail.com',
                'username' => 'Fiksa', 'password' => password_hash('12345', PASSWORD_DEFAULT),
                'jabatan' => 'Owner'
            ],
            [
                'id_admin' => 'ad532', 'nama' => 'Nissa', 'email' => 'Nissa@gmail.com',
                'username' => 'nissa', 'password' => password_hash('12345', PASSWORD_DEFAULT),
                'jabatan' => 'Owner'
            ],
            [
                'id_admin' => 'ad934', 'nama' => 'Putra', 'email' => 'putra@gmail.com',
                'username' => 'Kecoaterbang', 'password' => password_hash('12345', PASSWORD_DEFAULT),
                'jabatan' => 'Staff'
            ],
        ];

        $this->db->table('admin')->insertBatch($data);
    }
}