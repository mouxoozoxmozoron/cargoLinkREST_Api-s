<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UserRegistrationRequest extends FormRequest
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
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|digits_between:10,12|numeric|unique:users,phone_number',
            'password' => 'string|required|',
            'profile_image' => 'nullable',
            'user_type_id' => 'nullable'

        ];
    }

    public function messages(){
        return [
            'phone_number.digits' => 'phone number should range from 10 to 12 digits.',
            'email.unique' => 'Email already exist!.',
            'phone_number.unique' => 'phonenumber already exist.',
            'password.required' => 'password field is required',
            'first_name.required' => 'first_name field is required',
            'last_name.required' => 'last_name field is required',
        ];
    }
}

