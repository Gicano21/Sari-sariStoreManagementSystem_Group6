<?php

namespace App\Controllers;

use App\Models\ProductModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $user = auth()->user();

        return view('pages/dashboard', [
            'products' => $productModel->getProducts(),
            'productCount' => $productModel->getProductCount(),
            'stockCount' => $productModel->getStockCount(),
            'isOwnerLoggedIn' => auth()->loggedIn(),
            'ownerName' => $user?->username ?? $user?->name ?? '',
        ]);
    }
}
