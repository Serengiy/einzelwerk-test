<?php

namespace App\Http\Requests\API;

use App\DTOs\Auth\RegisterUserDTO;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ];
    }

    public function getData(): RegisterUserDTO
    {
        $data = $this->validated();
        return new RegisterUserDTO(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
        );
    }
}
