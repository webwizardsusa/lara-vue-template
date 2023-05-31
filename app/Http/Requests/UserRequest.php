<?php

namespace App\Http\Requests;

class UserRequest extends BaseRequest
{
    protected $id;

    public function __construct()
    {
        $this->id = request()->route('user');
    }

    public function rules()
    {
        $rules = [
            'email' => "required|unique:users,email,{$this->id},id,deleted_at,NULL",
            'password' => 'required',
            'name' => 'required|string',
            'role_id' => 'required|integer',
        ];

        if ($this->id) {
            unset($rules['password']);
        }

        return $rules;
    }
}
