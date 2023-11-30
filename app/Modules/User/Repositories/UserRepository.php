<?php

namespace App\Modules\User\Repositories;

use App\Models\User;

class UserRepository
{
    public function firstBy(string $value, string $column): ?User
    {
        return User::query()->where([$column => $value])->first();
    }

    public function create(array $validated): User
    {
        return User::query()->create($validated);
    }
}
