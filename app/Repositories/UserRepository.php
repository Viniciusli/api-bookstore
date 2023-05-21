<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all()
    {
        return $this->user->all();
    }

    public function byRole(string $role)
    {
        return $this->user->role($role)->get();
    }

    public function create(array $data)
    {
        return $this->user->create($data);
    }

    public function assignRole(User $user, string $role)
    {
        return $user->assignRole($role);
    }
}
