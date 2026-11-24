<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SaleTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'sale_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'owner_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'sale_datetime' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('sale_id', true);

        $this->forge->addForeignKey('owner_id', 'store_owners', 'owner_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('sales');
    }

    public function down()
    {
        $this->forge->dropTable('sales');
    }
}
