<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classificacao extends Model
{
    protected $fillable = [
        'id_campeonato',
        'id_time',
        'pontuacao',
    ];
    use HasFactory;
}
