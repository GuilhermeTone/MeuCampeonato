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
        Schema::create('jogos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_campeonato')->nullable();
            $table->unsignedBigInteger('id_time_mandante')->nullable();
            $table->unsignedBigInteger('id_time_visitante')->nullable();
            $table->foreign('id_campeonato')->references('id')->on('campeonatos');
            $table->foreign('id_time_mandante')->references('id')->on('participantes');
            $table->foreign('id_time_visitante')->references('id')->on('participantes');
            $table->integer('gols_casa')->nullable();
            $table->integer('gols_fora')->nullable();
            $table->integer('resultado_final')->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jogos');
    }
};
