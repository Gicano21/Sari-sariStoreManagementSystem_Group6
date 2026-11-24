<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class StoreOwnerTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'owner_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
        $this->forge->addKey('owner_id', true);
        $this->forge->createTable('store_owners');
    }

    public function down()
    {
        $this->forge->dropTable('store_owners');
    }
}
