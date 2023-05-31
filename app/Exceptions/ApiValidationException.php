<?php

namespace App\Exceptions;

use Exception;

class ApiValidationException extends Exception
{

    public $validator;

    public function __construct($validator)
    {
        $this->validator = $validator;
    }

    public function render($request)
    {
        $errors = $this->validator->errors();
        $message = 'Validation errors';

        $errorString = '';
        foreach (collect($errors)->all() as $error) {
            if (@$error[0]) {
                $errorString .= '<li>' . @$error[0] . '</li>';
            }
        }
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errorString,
        ], 422);
    }
}
