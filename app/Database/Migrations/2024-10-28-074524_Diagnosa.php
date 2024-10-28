<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Diagnosa extends Migration
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
            'no_kunjungan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'id_pasien' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'catatan_anamnesa' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'catatan_obat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'img1' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'img2' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'img3' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'img4' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'unit_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
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
        $this->forge->createTable('diagnosa'); // Create the pasien table
    }

    public function down()
    {
        $this->forge->dropTable('diagnosa');
    }
}
