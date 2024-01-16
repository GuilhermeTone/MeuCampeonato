<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Jogos;
use App\Models\Campeonatos;

class HistoricoController extends Controller
{
    public function historico()
    {
        return Campeonatos::with(['primeiroColocado', 'segundoColocado', 'terceiroColocado', 'quartoColocado'])->get();
    }
}
