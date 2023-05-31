<?php

namespace App\Http\Requests;

use App\Models\User;

class AuthRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $user = User::where('email', $value)->first();

                    if (!$user) {
                        $fail('Email does not exist.');
                    }
                }
            ],
            'password' => 'required'
        ];
    }
}
