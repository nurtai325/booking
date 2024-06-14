<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id('chat_session_id');
            $table->timestamps();
            $table->string('phone')->unique();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id('message_id');
            $table->timestamps();
            $table->integer('chat_session_id');
            $table->text('content');
            $table->text('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_sessions');
        Schema::dropIfExists('messages');
    }
};
