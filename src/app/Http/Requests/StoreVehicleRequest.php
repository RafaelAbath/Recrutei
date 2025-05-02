<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        // se você tiver política específica, mude aqui
        return true;
    }

    public function rules(): array
    {
        return [
            'plate'      => ['required', 'string', 'max:10', 'unique:vehicles,plate'],
            'make'       => ['required', 'string', 'max:50'],
            'model'      => ['required', 'string', 'max:50'],
            'daily_rate' => ['required', 'numeric', 'min:0'],
        ];
    }
}
