<?php

namespace App\Modules\Auth\Services;

use App\Modules\User\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\NewAccessToken;

class AuthService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function attempt(string $email, string $password): bool
    {
        $user = $this->userRepository->firstBy($email, 'email');

        return Hash::check($password, $user->getAuthPassword());
    }

    public function generateToken(string $email, string $name = 'api'): NewAccessToken
    {
        $user = $this->userRepository->firstBy($email, 'email');

        return $user->generateToken($name);
    }
}
