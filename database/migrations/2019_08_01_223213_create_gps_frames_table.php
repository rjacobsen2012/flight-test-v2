<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGpsFramesTable extends Migration
{
    public function up(): void
    {
        Schema::create('gps_frames', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('timestamp');
            $table->unsignedBigInteger('flight_id');
            $table->decimal('lat', 9, 6);
            $table->decimal('long', 9, 6);
            $table->decimal('alt', 9, 1);
            $table->timestamps();

            $table->foreign('flight_id')->references('id')->on('flights');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gps_frames');
    }
}
