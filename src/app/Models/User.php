<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;   // ❶
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements JWTSubject   // ❷
{
    use HasFactory, Notifiable;

    
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /** -----------------------------------------------------------------
     * Mutator para salvar senha sempre hashada
     * ----------------------------------------------------------------*/
    public function setPasswordAttribute($value)
{
    $this->attributes['password'] = Hash::make($value);
}

    
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
