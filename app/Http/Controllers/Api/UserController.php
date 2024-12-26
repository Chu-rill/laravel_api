<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Register a new user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        }
        
        Log::info('Registering new user', ['data' => $validatedData]);
        
        $user = $this->userService->register($validatedData);
        Log::info('User created', ['user' => $user]);
        if (!$user) {
            return response()->json(['message' => 'User creation failed'], 500);
        }

        return response()->json([
            'message' => 'User created successfully', 
            'user' => new UserResource($user),
        ], 201);
    }

    /**
     * Authenticate a user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $authData = $this->userService->authenticate($credentials);

        return response()->json([
            'message' => 'Login successful',
            'token' => $authData['token'],
            'user' => $authData['user'],
        ], 200);
    }
}
