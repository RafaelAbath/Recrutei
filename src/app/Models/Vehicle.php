<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Vehicle extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['plate', 'make', 'model', 'daily_rate'];

    
    public function toSearchableArray(): array
    {
        return [
            'plate'      => $this->plate,
            'make'       => $this->make,
            'model'      => $this->model,
            'daily_rate' => $this->daily_rate,
        ];
    }
}
