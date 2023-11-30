<?php

namespace App\Http\Controllers\API;

use App\Core\Helpers\ApiResponder;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\TokenResource;
use App\Http\Resources\UserResource;
use App\Modules\Auth\Exceptions\AuthException;
use App\Modules\Auth\Services\AuthService;
use App\Modules\User\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService, private readonly UserService $userService)
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->userService->store($request->validated());

        return ApiResponder::success(new UserResource($user), Response::HTTP_CREATED);
    }

    /**
     * @throws AuthException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (! $this->authService->attempt($request->email, $request->password)) {
            throw AuthException::unauthorized();
        }

        $token = $this->authService->generateToken($request->email);

        return ApiResponder::success(new TokenResource($token));
    }
}
