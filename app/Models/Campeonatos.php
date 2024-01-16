<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Participantes;

class Campeonatos extends Model
{
    protected $fillable = [
        'id_time_primeiro_colocado',
        'id_time_segundo_colocado',
        'id_time_terceiro_colocado',
        'id_time_quarto_colocado',
    ];

    public function primeiroColocado()
    {
        return $this->belongsTo(Participantes::class, 'id_time_primeiro_colocado');
    }

    public function segundoColocado()
    {
        return $this->belongsTo(Participantes::class, 'id_time_segundo_colocado');
    }

    public function terceiroColocado()
    {
        return $this->belongsTo(Participantes::class, 'id_time_terceiro_colocado');
    }

    public function quartoColocado()
    {
        return $this->belongsTo(Participantes::class, 'id_time_quarto_colocado');
    }
    use HasFactory;
}
