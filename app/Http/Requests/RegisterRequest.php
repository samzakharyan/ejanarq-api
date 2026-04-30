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
            'user_type' => ['required', Rule::enum(UserTypeEnum::class)],
            'first_name' => 'required_if:user_type,user|nullable|string|max:20',
            'last_name' => 'required_if:user_type,user|nullable|string|max:20',
            'name' => 'required_if:user_type,shop|nullable|string|max:20',
            'tax_id' => ['required_if:user_type,shop','nullable','string','unique:users,tax_id'],
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Անունը պարտադիր է',
            'last_name.required' => 'Ազգանունը պարտադիր է',
            'name.required' => 'Անունը պարտադիր է',
            'tax_id.required' => 'ՀՎՀՀ-ն պարտադիր է',
            'tax_id.unique' => 'ՀՎՀՀ-ն արդեն օգտագործված է',
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
            firstName: $data['first_name'] ?? null,
            lastName: $data['last_name'] ?? null,
            name: $data['name'] ?? null,
            taxId: $data['tax_id'] ?? null,
            email: $data['email'],
            type: $data['user_type'],
            password: $data['password'],
        );
    }
}
