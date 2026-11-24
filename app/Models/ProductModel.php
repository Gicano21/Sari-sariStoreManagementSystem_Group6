<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $returnType = 'array';
    protected $allowedFields = ['product_name', 'category', 'unit_price', 'stock_quantity'];

    public function getProducts(): array
    {
        return $this->orderBy('product_name', 'ASC')->findAll();
    }

    public function getProductCount(): int
    {
        return $this->countAllResults();
    }

    public function getStockCount(): int
    {
        $result = $this->selectSum('stock_quantity', 'total_stock')->first();

        return (int) ($result['total_stock'] ?? 0);
    }

    public function isUsedInSales(int $productId): bool
    {
        return $this->db->table('sale_items')
            ->where('product_id', $productId)
            ->countAllResults() > 0;
    }
}
