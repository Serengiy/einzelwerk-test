<?php

namespace App\Http\Requests\API;

use App\DTOs\Contragent\ContragentStoreDTO;
use App\Exceptions\HttpException;
use App\Models\User;
use App\Rules\InnRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ContragentStoreRequest extends FormRequest
{
    private User $user;
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'user_id' => ['required', 'integer', 'exists:users,id']
        ];
    }

    /**
     * @throws HttpException
     */
    public function passedValidation(): void
    {
        /** @var User $user */
        $user = User::query()->find($this->user_id);
        if ($user->contragent()->exists()) {
            throw new HttpException('User already is contragent');
        }

        $this->user = $user;
    }

    public function getData(): ContragentStoreDTO
    {
        $data = $this->validated();
        return new ContragentStoreDTO(
            inn: $data['inn'],
            user: $this->user,
        );
    }
}
