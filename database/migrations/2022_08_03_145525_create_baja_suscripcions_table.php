<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baja_suscripcions', function (Blueprint $table) {
            $table->id();
            $table->integer('suscripcion_id');
            $table->string('nombre');
            $table->string('email');
            $table->date('fecha_baja');
            $table->integer('eliminado')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('baja_suscripcions');
    }
};
