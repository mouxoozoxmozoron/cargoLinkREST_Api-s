<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class transport_agent_creation extends FormRequest
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
            'name' => 'required|string|unique:transportation_companies,name',
            'bank_acount_number' => 'required|string',
            'bank_type' => 'required|string',
            'location' => 'required|string',
            'company_category' => 'required|string',
            'routes' => 'required|string',
            'agent_logo' => 'string|nullable',
            'working_day' => 'required|string',
            'contact' => 'required|string',
            'email' => 'required|unique:transportation_companies,email',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'name field cant be empty.',
            'name.unique' => 'company name already exist.',
            'bank_acount_number.required' => 'baank account number is required.',
            'bank_type.required' => 'bank type is required.',
            'location.required' => 'location field cant be empty',
            'company_category.required' => 'company category is required',
            'routes.required' => 'route field is required',
            'working_day.required' => 'working day is required',
            'contact.required' => 'contact is required',
            'email.unique' => 'Email already exist',
            'email.required' => 'Email field is required',


        ];
    }
}
