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
        Schema::create('campeonatos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_time_primeiro_colocado')->nullable();
            $table->unsignedBigInteger('id_time_segundo_colocado')->nullable();
            $table->unsignedBigInteger('id_time_terceiro_colocado')->nullable();
            $table->unsignedBigInteger('id_time_quarto_colocado')->nullable();
            $table->foreign('id_time_primeiro_colocado')->references('id')->on('participantes');
            $table->foreign('id_time_segundo_colocado')->references('id')->on('participantes');
            $table->foreign('id_time_terceiro_colocado')->references('id')->on('participantes');
            $table->foreign('id_time_quarto_colocado')->references('id')->on('participantes');
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campeonatos');
    }
};
