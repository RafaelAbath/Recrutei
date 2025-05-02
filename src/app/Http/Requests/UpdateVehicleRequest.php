<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // $this->vehicle vem do model-binding da rota
        return [
            'plate'      => ['sometimes', 'string', 'max:10',
                             'unique:vehicles,plate,' . $this->vehicle->id],
            'make'       => ['sometimes', 'string', 'max:50'],
            'model'      => ['sometimes', 'string', 'max:50'],
            'daily_rate' => ['sometimes', 'numeric', 'min:0'],
        ];
    }
}
