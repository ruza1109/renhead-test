<?php

namespace App\Http\Controllers;

use App\DTO\UserDTO;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Interfaces\TokenInterface;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserService    $userService,
        private readonly TokenInterface $token,
        private readonly UserRepository $userRepository,
    ) {}

    public function register(StoreUserRequest $request): JsonResponse
    {
        $userDTO = new UserDTO(
            email: $request['email'],
            firstName: $request['first_name'],
            lastName: $request['last_name'],
            type: $request['type'],
            password: $request['password']
        );

        $user = $this->userService->store($userDTO);
        $token = $this->token->generate($user);

        Auth::login($user);

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->userRepository->getUserByEmail($request['email']);

        if (!$user || !Hash::check($request['password'], $user->password)) {
            return response()->json([
               'message' => 'Bad credentials'
            ], 401);
        }

        $token = $this->token->generate($user);

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ]);
    }

    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }
}
