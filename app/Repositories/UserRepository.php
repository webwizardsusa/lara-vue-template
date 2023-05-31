<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function authenticate($request)
    {
        $credentials = $request->only('email', 'password');
        $valid = Auth::attempt($credentials);
        if (!$valid) {
            return false;
        }
        $user = Auth::user();
        $token = auth()->login($user);

        $data = [
            'token' => $token
        ];

        return $data;
    }
}
