<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\Extension\Attributes\Node\Attributes;

class Record extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $primaryKey = "record_id";

    protected $attributes = [
        'canceled' => false,
    ];
}
