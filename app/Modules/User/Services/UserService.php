<?php

namespace App\Modules\User\Services;

use App\Models\User;
use App\Modules\User\Repositories\UserRepository;

class UserService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function findFirstBy(string $value, string $column): ?User
    {
        return $this->userRepository->firstBy($value, $column);
    }

    public function store(array $validated): User
    {
        return $this->userRepository->create($validated);
    }
}
