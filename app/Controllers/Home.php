<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\StoreOwnerModel;

class Home extends BaseController
{
    public function index()
    {
        return redirect()->to('/dashboard');
    }

    public function login()
    {
        return redirect()->to('/dashboard');
    }

    public function AuthenticateStoreOwner(){
        $username = trim((string) $this->request->getPost('username'));
        $password = $this->request->getPost('password');
        $storeOwner = (new StoreOwnerModel())->findByUsername($username);

        if ($storeOwner && password_verify($password, $storeOwner['password'])) {
            session()->regenerate(true);
            session()->set([
                'owner_id' => $storeOwner['owner_id'],
                'owner_name' => $storeOwner['name'],
            ]);

            return redirect()->to('/dashboard');
        }

        return redirect()->back()->withInput()->with('error', 'Invalid username or password');
    }

    public function registerStoreOwner()
    {
        if ($this->isStoreOwnerLoggedIn()) {
            return redirect()->to('/dashboard');
        }

        $rules = [
            'name' => 'required|max_length[255]',
            'username' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|max_length[255]',
            'password' => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/dashboard')->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = trim((string) $this->request->getPost('name'));
        $username = trim((string) $this->request->getPost('username'));
        $email = strtolower(trim((string) $this->request->getPost('email')));
        $ownerModel = new StoreOwnerModel();

        if ($ownerModel->usernameExists($username)) {
            return redirect()->to('/dashboard')->withInput()->with('errors', [
                'username' => 'That username is already registered.',
            ]);
        }

        if ($ownerModel->emailExists($email)) {
            return redirect()->to('/dashboard')->withInput()->with('errors', [
                'email' => 'That email address is already registered.',
            ]);
        }

        $ownerModel->insert([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
        ]);

        return redirect()->to('/dashboard')->with('success', 'Account created. Sign in with your new account to manage the store.');
    }

    public function dashboard(){
        $productModel = new ProductModel();

        return view('pages/dashboard', [
            'products' => $productModel->getProducts(),
            'productCount' => $productModel->getProductCount(),
            'stockCount' => $productModel->getStockCount(),
            'isOwnerLoggedIn' => $this->isStoreOwnerLoggedIn(),
            'ownerName' => session()->get('owner_name'),
        ]);
    }

    public function createProduct()
    {
        if (! $this->isStoreOwnerLoggedIn()) {
            return redirect()->to('/dashboard');
        }

        if (! $this->validate($this->productRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new ProductModel())->insert($this->productData());

        return redirect()->to('/dashboard')->with('success', 'Product added successfully.');
    }

    public function updateProduct(int $productId)
    {
        if (! $this->isStoreOwnerLoggedIn()) {
            return redirect()->to('/dashboard');
        }

        if (! $this->validate($this->productRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $productModel = new ProductModel();
        if (! $productModel->find($productId)) {
            return redirect()->to('/dashboard')->with('error', 'Product not found.');
        }

        $productModel->update($productId, $this->productData());

        return redirect()->to('/dashboard')->with('success', 'Product updated successfully.');
    }

    public function deleteProduct(int $productId)
    {
        if (! $this->isStoreOwnerLoggedIn()) {
            return redirect()->to('/dashboard');
        }

        $productModel = new ProductModel();
        if (! $productModel->find($productId)) {
            return redirect()->to('/dashboard')->with('error', 'Product not found.');
        }

        if ($productModel->isUsedInSales($productId)) {
            return redirect()->to('/dashboard')->with('error', 'This product is part of sales history and cannot be deleted.');
        }

        $productModel->delete($productId);

        return redirect()->to('/dashboard')->with('success', 'Product deleted successfully.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login');
    }

    private function isStoreOwnerLoggedIn(): bool
    {
        return session()->has('owner_id');
    }

    private function productRules(): array
    {
        return [
            'product_name' => 'required|max_length[255]',
            'category' => 'required|max_length[255]',
            'unit_price' => 'required|decimal|greater_than_equal_to[0]',
            'stock_quantity' => 'required|integer|greater_than_equal_to[0]',
        ];
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
