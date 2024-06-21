<?php

namespace server\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PHPUnit\TextUI\XmlConfiguration\SchemaDetectionResult;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("service_groups", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string("name")->unique();
            $table->string("description");
            $table->string("additional_info")->nullable();

            $table->foreign("user_id")->references("id")->on("users");
        });

        Schema::create("services", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_group');
            $table->string("name")->unique();
            $table->string("description");
            $table->float("price");
            $table->integer("quantity");
            $table->string("additional_info")->nullable();
            $table->integer('duration');

            $table->foreign("service_group")->references("id")->on("service_group");
        });

        Schema::create("bookings", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("service_id");
            $table->time("start_time");
            $table->time("end_time");
            $table->integer("booked");

            $table->foreign("service_id")->references("id")->on("services");
        });

        Schema::create("records", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("phone");
            $table->string("additional_info")->nullable();
            $table->timestamps();
            $table->integer("quantity");

            $table->foreign("booking_id")->references("id")->on("bookings");
        });

        Schema::create("record_bookings", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("record_id");
            $table->unsignedBigInteger("booking_id");

            $table->foreign("booking_id")->references("id")->on("bookings");
            $table->foreign("record_id")->references("id")->on("records");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_groups');
        Schema::dropIfExists('service');
        Schema::dropIfExists('records');
        Schema::dropIfExists('record_bookings');
    }
};
