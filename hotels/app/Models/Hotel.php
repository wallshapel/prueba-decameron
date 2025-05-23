<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'nit',
        'room_limit',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
}
