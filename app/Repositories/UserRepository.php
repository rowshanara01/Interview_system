<?php

namespace App\Repositories;

use Exception;
use App\Models\User;

class UserRepository
{
    public function __construct(protected User $model){}

    public function index()
    {
        $users = $this->model->where('role', 'user')->get();

        return $users;
    }

}
