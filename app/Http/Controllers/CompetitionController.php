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
use App\Models\Classificacao;
use App\Models\Participantes;

class CompetitionController extends Controller
{
    public function getTeams()
    {
        return Participantes::all();
    }
    public function realizarCampeonato(Request $request)
    {
        $times = $request->get('timesSelecionados');
        if (count($times) != 8) {
            return response()->json(['error' => "Para construção da competição precisará de exatamente 8 times"], 422);
        }

        shuffle($times);

        $arrays_separados = array_chunk($times, 2);

        $campeonato = new Campeonatos;

        $classificacao = new Classificacao;
        $campeonato->save();
        $idCampeonato = $campeonato->id;
        $terceiroQuarto = [];

        $this->realizaClassificatoria($arrays_separados, $idCampeonato);

        $jogos = Jogos::where('id_campeonato', $idCampeonato)->orderBy('id', 'desc')->take(4)->get()->toArray();
        $semiFinal = [];
        foreach ($jogos as $key => $value) {
            if ($value['resultado_final'] == 0) {
                $semiFinal[] = $value['id_time_visitante'];
            } else {
                if ($value['gols_casa'] > $value['gols_fora']) {
                    $semiFinal[] = $value['id_time_mandante'];
                } else {
                    $semiFinal[] = $value['id_time_visitante'];
                }
            }
        }
        $semiFinal = array_chunk($semiFinal, 2);
        $this->realizaClassificatoria($semiFinal, $idCampeonato);

        $jogos = Jogos::where('id_campeonato', $idCampeonato)->orderBy('id', 'desc')->take(2)->get()->toArray();

        $final = [];
        $terceiroQuarto = [];
        foreach ($jogos as $key => $value) {
            if ($value['resultado_final'] == 0) {
                $pontuacaoMandante = Classificacao::where('id_campeonato', $idCampeonato)
                ->where('id_time', $value['id_time_mandante'])
                ->first();
                $pontuacaoVisitante = Classificacao::where('id_campeonato', $idCampeonato)
                ->where('id_time', $value['id_time_visitante'])
                ->first();

                if ($pontuacaoMandante->pontuacao > $pontuacaoVisitante->pontuacao) {
                    $terceiroQuarto[] = $value['id_time_visitante'];
                    $final[] = $value['id_time_mandante'];
                } else {
                    $terceiroQuarto[] = $value['id_time_mandante'];
                    $final[] = $value['id_time_visitante'];
                }
            } else {
                if ($value['gols_casa'] > $value['gols_fora']) {
                    $terceiroQuarto[] = $value['id_time_visitante'];
                    $final[] = $value['id_time_mandante'];
                } else {
                    $terceiroQuarto[] = $value['id_time_mandante'];
                    $final[] = $value['id_time_visitante'];
                }
            }
        }



        $resultado = shell_exec('python3 /var/www/app/Http/Controllers/script.py');
        $resultado = explode(',', $resultado);

        $this->realizaJogo($idCampeonato, $final[0], $final[1], $resultado);

        $jogos = Jogos::where('id_campeonato', $idCampeonato)->orderBy('id', 'desc')->take(1)->get()->toArray();

        foreach ($jogos as $key => $value) {
            if ($value['resultado_final'] == 0) {
                $pontuacaoMandante = Classificacao::where('id_campeonato', $idCampeonato)
                    ->where('id_time', $value['id_time_mandante'])
                    ->first();
                $pontuacaoVisitante = Classificacao::where('id_campeonato', $idCampeonato)
                    ->where('id_time', $value['id_time_visitante'])
                    ->first();

                if ($pontuacaoMandante->pontuacao > $pontuacaoVisitante->pontuacao) {
                    $campeonato->id_time_primeiro_colocado = $value['id_time_mandante'];
                    $campeonato->id_time_segundo_colocado = $value['id_time_visitante'];
                } else {
                    $campeonato->id_time_primeiro_colocado = $value['id_time_visitante'];
                    $campeonato->id_time_segundo_colocado = $value['id_time_mandante'];
                }
            } else {
                if ($value['gols_casa'] > $value['gols_fora']) {
                    $campeonato->id_time_primeiro_colocado = $value['id_time_mandante'];
                    $campeonato->id_time_segundo_colocado = $value['id_time_visitante'];
                } else {
                    $campeonato->id_time_primeiro_colocado = $value['id_time_visitante'];
                    $campeonato->id_time_segundo_colocado = $value['id_time_mandante'];
                }
            }
        }

        $this->realizaJogo($idCampeonato, $terceiroQuarto[0], $terceiroQuarto[1], $resultado);

        $jogos = Jogos::where('id_campeonato', $idCampeonato)->orderBy('id', 'desc')->take(1)->get()->toArray();

        foreach ($jogos as $key => $value) {
            if ($value['resultado_final'] == 0) {
                $pontuacaoMandante = Classificacao::where('id_campeonato', $idCampeonato)
                    ->where('id_time', $value['id_time_mandante'])
                    ->first();
                $pontuacaoVisitante = Classificacao::where('id_campeonato', $idCampeonato)
                    ->where('id_time', $value['id_time_visitante'])
                    ->first();

                if ($pontuacaoMandante->pontuacao > $pontuacaoVisitante->pontuacao) {
                    $campeonato->id_time_terceiro_colocado = $value['id_time_mandante'];
                    $campeonato->id_time_quarto_colocado = $value['id_time_visitante'];
                } else {
                    $campeonato->id_time_terceiro_colocado = $value['id_time_visitante'];
                    $campeonato->id_time_quarto_colocado = $value['id_time_mandante'];
                }
            } else {
                if ($value['gols_casa'] > $value['gols_fora']) {
                    $campeonato->id_time_terceiro_colocado = $value['id_time_mandante'];
                    $campeonato->id_time_quarto_colocado = $value['id_time_visitante'];
                } else {
                    $campeonato->id_time_terceiro_colocado = $value['id_time_visitante'];
                    $campeonato->id_time_quarto_colocado = $value['id_time_mandante'];
                }
            }
        }
        $colocacaoFinal['primeiro_lugar']= Participantes::find($campeonato->id_time_primeiro_colocado)->name;
        $colocacaoFinal['segundo_lugar'] =  Participantes::find($campeonato->id_time_segundo_colocado)->name;
        $colocacaoFinal['terceiro_lugar'] = Participantes::find($campeonato->id_time_terceiro_colocado)->name;
        $colocacaoFinal['quarto_lugar'] = Participantes::find($campeonato->id_time_quarto_colocado)->name;
        $campeonato->save();

        return response()->json(['sucesso' => $colocacaoFinal], 202);
    }
    private function realizaJogo($idCampeonato, $time_mandante, $time_visitante, $resultado = [])
    {
        $jogo = new Jogos;
        $jogo->id_campeonato = $idCampeonato;
        $jogo->id_time_mandante = $time_mandante;
        $jogo->id_time_visitante = $time_visitante;
        $jogo->gols_casa = trim($resultado[0]);
        $jogo->gols_fora = trim($resultado[1]);
        $jogo->resultado_final = max($resultado[0], $resultado[1]) - min($resultado[0], $resultado[1]);
        $jogo->save();
    }
    private function realizaClassificacao($idCampeonato, $idTime, $resultado = [])
    {
        $existingClassificacao = Classificacao::where('id_campeonato', $idCampeonato)
            ->where('id_time', $idTime)
            ->first();

        if ($existingClassificacao) {
            $existingClassificacao->update([
                'pontuacao' => $existingClassificacao->pontuacao + ($resultado[0] - $resultado[1] < 0 ? 0 : $resultado[0] - $resultado[1]),
            ]);
        } else {
            $classificacao = new Classificacao;
            $classificacao->id_campeonato = $idCampeonato;
            $classificacao->id_time = $idTime;
            $classificacao->pontuacao = $resultado[0] - $resultado[1] < 0 ? 0 : $resultado[0] - $resultado[1];
            $classificacao->save();
        }
    }
    private function realizaClassificatoria($arrayTimes, $idCampeonato)
    {
        foreach ($arrayTimes as $index => $value) {


            $resultado = shell_exec('python3 /var/www/app/Http/Controllers/script.py');
            $resultado = explode(',', $resultado);

            $this->realizaJogo($idCampeonato, $value[0], $value[1], $resultado);

            $this->realizaClassificacao($idCampeonato, $value[0], $resultado);

            $this->realizaClassificacao($idCampeonato, $value[1], $resultado);
        }
    }
}
