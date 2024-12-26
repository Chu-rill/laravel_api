<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Register a new user.
     *
     * @param array $data
     * @return mixed
     */
    public function register(array $data)
    {
        Log::info('Registering user with data', ['data' => $data]);
        return $this->userRepository->create($data);
    }

    /**
     * Authenticate a user and generate a token.
     *
     * @param array $credentials
     * @return string
     * @throws ValidationException
     */
    public function authenticate(array $credentials): string
    {
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = Auth::user();
        return $user->createToken('auth_token')->plainTextToken;

        
    }
}
