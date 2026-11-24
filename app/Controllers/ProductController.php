<?php

namespace App\Controllers;

use App\Models\ProductModel;

class ProductController extends BaseController
{
    public function create()
    {
        $model = new ProductModel();
        $data = $this->productData();

        if (! $model->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        $model->insert($data);

        return redirect()->to('/dashboard')->with('success', 'Product added successfully.');
    }

    public function update(int $productId)
    {
        $model = new ProductModel();
        $data = $this->productData();

        if (! $model->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        if (! $model->find($productId)) {
            return redirect()->to('/dashboard')->with('error', 'Product not found.');
        }

        $model->update($productId, $data);

        return redirect()->to('/dashboard')->with('success', 'Product updated successfully.');
    }

    public function delete(int $productId)
    {
        $model = new ProductModel();

        if (! $model->find($productId)) {
            return redirect()->to('/dashboard')->with('error', 'Product not found.');
        }

        if ($model->isUsedInSales($productId)) {
            return redirect()->to('/dashboard')->with('error', 'This product is part of sales history and cannot be deleted.');
        }

        $model->delete($productId);

        return redirect()->to('/dashboard')->with('success', 'Product deleted successfully.');
    }

    private function productData(): array
    {
        return [
            'product_name' => trim((string) $this->request->getPost('product_name')),
            'category' => trim((string) $this->request->getPost('category')),
            'unit_price' => $this->request->getPost('unit_price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
        ];
    }
}
