<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_id';
    protected $guarded = [];
    protected $attributes = [
        'duration' => 60
    ];

    public function booking(): HasMany {
        return $this->hasMany(Booking::class, 'service_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
