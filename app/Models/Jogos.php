<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jogos extends Model
{
    protected $fillable = [
        'id_time_mandante',
        'id_time_visitante',
        'gols_casa',
        'gols_fora',
        'resultado_final'
    ];
    use HasFactory;
}
