<?php

namespace App\Models;

use CodeIgniter\Model;

class StoreOwnerModel extends Model
{
    protected $table = 'store_owners';
    protected $primaryKey = 'owner_id';
    protected $returnType = 'array';
    protected $allowedFields = ['name', 'username', 'email', 'password'];

    protected $validationRules = [
        'name' => 'required|max_length[255]',
        'username' => 'required|min_length[3]|max_length[30]',
        'email' => 'required|valid_email|max_length[254]',
        'password' => 'required|min_length[8]|max_length[255]',
    ];

    public function findByUsername(string $username): ?array
    {
        $owner = $this->where('username', $username)->first();

        return $owner ?: null;
    }

    public function usernameExists(string $username): bool
    {
        return $this->where('username', $username)->countAllResults() > 0;
    }

    public function emailExists(string $email): bool
    {
        return $this->where('email', $email)->countAllResults() > 0;
    }
}
