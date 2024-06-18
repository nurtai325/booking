<?php

namespace server\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("services", function (Blueprint $table) {
            $table->id("service_id");
            $table->unsignedBigInteger('user_id');
            $table->string("name")->unique();
            $table->string("description");
            $table->float("price");
            $table->integer("capacity");
            $table->timestamps();
            $table->string("additional_info")->nullable();
            $table->integer('duration');

            $table->foreign("user_id")->references("id")->on("users");
        });

        Schema::create("bookings", function (Blueprint $table) {
            $table->id("booking_id");
            $table->unsignedBigInteger("service_id");
            $table->time("start_time");
            $table->timestamps();

            $table->foreign("service_id")->references("service_id")->on("services");
        });

        Schema::create("records", function (Blueprint $table) {
            $table->id("record_id");
            $table->string("name");
            $table->string("phone");
            $table->string("additional_info")->nullable();
            $table->unsignedBigInteger("booking_id");
            $table->boolean("canceled");
            $table->timestamps();

            $table->foreign("booking_id")
                ->references("booking_id")->on("bookings");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
