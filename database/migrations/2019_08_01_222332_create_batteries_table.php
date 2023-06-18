<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBatteriesTable extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('batteries')) {
            Schema::create('batteries', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('battery_name');
                $table->string('battery_sn');
                $table->unsignedBigInteger('drone_id');
                $table->timestamps();

                $table->foreign('drone_id')->references('id')->on('drones');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('batteries');
    }
}
