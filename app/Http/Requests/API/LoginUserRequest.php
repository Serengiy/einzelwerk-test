<?php

namespace App\Http\Requests\API;

use App\DTOs\Auth\LoginUserDTO;
use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', 'exists:users,email'],
            'password' => ['required', 'string'],
        ];
    }

    public function getData(): LoginUserDTO
    {
        $data = $this->validated();

        return new LoginUserDTO(
            email: $data['email'],
            password: $data['password'],
        );
    }
}
