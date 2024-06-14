<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatSession extends Model
{
    use HasFactory;

    protected $primaryKey = 'chat_session_id';
    protected $table = 'chat_sessions';
    protected $guarded = [];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'chat_session_id', 'chat_session_id');
    }
}
