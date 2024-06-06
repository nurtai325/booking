<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    protected $primaryKey = 'booking_id';

    protected $guarded = [];

    protected $attributes = [
    ];

    public function service(): BelongsTo {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }

    public function records(): HasMany {
        return $this->hasMany(Record::class, 'booking_id', 'booking_id');
    }
}
