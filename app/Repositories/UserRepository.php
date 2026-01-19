<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository 
{
    public function __construct(
        private User $model
    )
    {}
    
    /**
     * Creates a user in the database.
     *
     * @param array $data
     * @return mixed
     */
    public function createUser(array $data): mixed
    {
        return $this->model->create($data);
    }
}