<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'type',
        'accommodation',
        'quantity',
    ];

    protected $hidden = [
        'id',
        'hotel_id',
        'created_at',
        'updated_at',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
