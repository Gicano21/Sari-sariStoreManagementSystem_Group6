<?php

namespace App\Models;

use CodeIgniter\Model;

class StoreOwnerModel extends Model
{
    protected $table = 'store_owners';
    protected $primaryKey = 'owner_id';
    protected $returnType = 'array';
    protected $allowedFields = ['name', 'username', 'email', 'password'];

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
