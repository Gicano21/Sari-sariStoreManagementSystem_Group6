<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialData extends Seeder
{
    public function run(): void
    {
        $this->seedData('store_owners', [
            [
                'username' => 'owner1',
                'password' => password_hash('password1', PASSWORD_DEFAULT),
                'name' => 'Owner One',
                'email' => 'owner1@example.com',
            ],
        ]);

        $this->seedData('products', [
            [
                'product_name' => 'Shampoo',
                'category' => 'Personal Care',
                'unit_price' => 5.99,
                'stock_quantity' => 100,
            ],
            [
                'product_name' => 'Soap',
                'category' => 'Personal Care',
                'unit_price' => 2.49,
                'stock_quantity' => 200,
            ],
            [
                'product_name' => 'Toothpaste',
                'category' => 'Personal Care',
                'unit_price' => 3.99,
                'stock_quantity' => 150,
            ],
        ]);

        $this->seedData('sales', [
            [
                'owner_id' => 1,
                'sale_datetime' => date('Y-m-d H:i:s'),
            ],
            [
                'owner_id' => 1,
                'sale_datetime' => date('Y-m-d H:i:s', strtotime('-1 day')),
            ],
        ]);

        $this->seedData('payments', [
            [
                'sale_id' => 1,
                'payment_method' => 'Cash',
                'amount_paid' => 5.99,
            ],
            [
                'sale_id' => 2,
                'payment_method' => 'Credit Card',
                'amount_paid' => 2.49,
            ],
        ]);

        $this->seedData('sale_items', [
            [
                'sale_id' => 1,
                'product_id' => 1,
                'quantity_sold' => 1,
                'unit_price_at_sale' => 5.99,
            ],
            [
                'sale_id' => 2,
                'product_id' => 2,
                'quantity_sold' => 1,
                'unit_price_at_sale' => 2.49,
            ],
            [
                'sale_id' => 2,
                'product_id' => 3,
                'quantity_sold' => 1,
                'unit_price_at_sale' => 3.99,
            ],
        ]);
    }

    public function seedData($table, $data)
    {
        echo "Seeding data for table: " . $table . PHP_EOL;
        return $this->db->table($table)->insertBatch($data);
    }
}
