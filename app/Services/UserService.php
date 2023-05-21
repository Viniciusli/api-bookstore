<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Spatie\Permission\Models\Role;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(array $data)
    {
        $user = $this->userRepository->create($data);

        $role = Role::findById($data['role_id']);

        $this->userRepository->assignRole($user, $role->name);
    }
}
