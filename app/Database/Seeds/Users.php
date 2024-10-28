<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        $data = [
            [
                'fullname' => 'Rizki Hamdani',
                'username' => 'Administrator',
                'email' => 'hamdaniversi08@gmail.com',
                'level' => 'Super Admin',
                'password' => md5('#admin123'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        // Masukkan data ke tabel users
        $this->db->table('users')->insertBatch($data);
    }
}
