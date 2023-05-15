<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json([
            $this->userService->getAll()
        ]);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json([$user]);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user = $this->userService->update($user, $request->validated());

        return response()->json([$user]);
    }

    public function delete(User $user): JsonResponse
    {
        $this->userService->delete($user);

        return response()->json(status: 204);
    }
}
