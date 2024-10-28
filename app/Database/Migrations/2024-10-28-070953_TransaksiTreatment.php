<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransaksiTreatment extends Migration
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
            'transaksi_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'no_antrian' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'pasien_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'tanggal' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'qty' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'subtotal' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'potongan' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'desc_pot' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'desc_pot' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'metode_bayar' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'no_transaksi' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'jumlah_dibayar' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'kembalian' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'img' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'deskripsi' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
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
        $this->forge->createTable('transaksi_treatment'); // Create the pasien table
    }

    public function down()
    {
        $this->forge->dropTable('transaksi_treatment'); // Drop the pasien table
    }
}
