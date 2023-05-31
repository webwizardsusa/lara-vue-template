<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Repositories\UserRepository;

class AuthController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(AuthRequest $request)
    {
        $response = $this->userRepository->authenticate($request);
        if ($response) {
            return $this->respondSuccess($response);
        }
        return $this->respondWithError('Invalid Credentials');
    }
}
