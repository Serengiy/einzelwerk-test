<?php

namespace App\Http\Requests\API;

use App\DTOs\Contragent\ContragentStoreDTO;
use App\Rules\InnRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ContragentStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'inn' => ['required', 'string', new InnRule()],
        ];
    }

    public function getData(): ContragentStoreDTO
    {
        $data = $this->validated();
        return new ContragentStoreDTO(
            inn: $data['inn'],
        );
    }
}
