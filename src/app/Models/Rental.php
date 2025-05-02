<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rental extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'vehicle_id',
        'customer_id',
        'start_date',
        'end_date',
        'total_amount',
    ];
    // -----------------------------

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
