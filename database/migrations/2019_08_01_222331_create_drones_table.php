<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDronesTable extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('drones')) {
            Schema::create('drones', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('aircraft_name');
                $table->string('aircraft_sn');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('drones');
    }
}
