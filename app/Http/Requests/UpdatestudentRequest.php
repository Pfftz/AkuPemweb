<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatestudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => "required",
            'address' => "required",
            'gender' => "required",
            'class' => "required",
            'age' => "required|integer|min:1",
            'phone' => "required",
            'email' => "required|email",
            'password' => "nullable|min:6|confirmed", // Optional, handle separately
        ];
    }
}
