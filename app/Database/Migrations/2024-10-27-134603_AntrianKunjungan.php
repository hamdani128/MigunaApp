<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AntrianKunjungan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'no_antrian' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'pasien_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_pasien' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'tanggal' => [
                'type' => 'date',
                'null' => true,
            ],
            'catatan_kunjungan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'unit_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_by' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_by' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true); // Set id as primary key
        $this->forge->createTable('antrian_kunjungan'); // Create the pasien table
    }

    public function down()
    {
        $this->forge->dropTable('antrian_kunjungan'); // Drop the pasien table
    }
}
