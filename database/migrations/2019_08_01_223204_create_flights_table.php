<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlightsTable extends Migration
{
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->unsignedBigInteger('drone_id');
            $table->timestamps();

            $table->foreign('drone_id')->references('id')->on('drones');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
}
