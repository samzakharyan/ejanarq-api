<?php

namespace App\Http\Requests;

use App\UserTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Dto\UserDto;

class RegisterRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'user_type' => ['required', Rule::enum(UserTypeEnum::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Անունը պարտադիր է',
            'last_name.required' => 'Ազգանունը պարտադիր է',
            'email.required' => 'Էլ․ հասցեն պարտադիր է',
            'email.email' => 'Էլ․ հասցեն անվավեր է',
            'email.unique' => 'Էլ․ հասցեն արդեն օգտագործված է',
            'password.required' => 'Գաղտնաբառը պարտադիր է',
            'password.min' => 'Գաղտնաբառը պետք է լինի առնվազն 6 նիշ',
            'password.confirmed' => 'Գաղտնաբառը չի համընկնում',
            'user_type.required' => 'Օգտագործողի տեսակը պարտադիր է',
            'user_type.enum' => 'Օգտագործողի տեսակը անվավեր է',
        ];
    }

    /**
     * @return UserDto
     */
    public function toDto(): UserDto
    {
        $data = $this->validated();

        return new UserDto(
            firstName: $data['first_name'],
            lastName: $data['last_name'],
            email: $data['email'],
            type: $data['user_type'],
            password: $data['password'],
        );
    }
}
