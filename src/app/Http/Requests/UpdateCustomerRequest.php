<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateCustomerRequest extends FormRequest
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
            'name'  => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email',
                Rule::unique('customers', 'email')->ignore($this->route('customer'))
            ],
            'phone' => ['sometimes', 'string', 'max:20'],
            'cnh'   => ['sometimes', 'string',
                Rule::unique('customers', 'cnh')->ignore($this->route('customer'))
            ],
        ];
    }
}
