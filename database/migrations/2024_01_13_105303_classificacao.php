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
        Schema::create('classificacaos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_campeonato')->nullable();
            $table->unsignedBigInteger('id_time')->nullable();
            $table->foreign('id_campeonato')->references('id')->on('campeonatos');
            $table->foreign('id_time')->references('id')->on('participantes');
            $table->integer('pontuacao');
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classificacaos');
    }
};
