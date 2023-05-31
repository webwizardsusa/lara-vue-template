<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PostRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'user_id' => [
                function ($attribute, $value, $fail) {
                    $id = Auth::id();
                    $user = User::find($id);
                    if (!$user->role_id == 2 && !$value) {
                        $fail('User must be selected');
                    }
                }
            ],
            'name' => 'required',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'User must be selected'
        ];
    }
}
