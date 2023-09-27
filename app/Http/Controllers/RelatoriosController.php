<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatoriosController extends Controller
{
    public function ranking()
    {
        try {
            $users = DB::table('users')
                ->join('servidor_portarias', 'users.matriculaSiape', '=', 'servidor_portarias.matriculaSiape')
                ->select('users.name', DB::raw('COUNT(servidor_portarias.id) AS quantidade'))
                ->groupBy('users.name')
                ->orderBy('quantidade')
                ->get();

            return response()->json($users, 200);
        } catch (\Throwable $err) {
            return response()->json($err, 500, ['mensagem' => 'Não foi possivel recuperar o ranking!']);
        }
    }

    public function portariasPublicas()
    {
        try {
            $portarias = DB::table('portarias')
                ->where('isPrivate', '=', 0)
                ->get();

            return response()->json($portarias, 200);
        } catch (\Throwable $err) {
            return response()->json($err, 500, ['mensagem' => 'Não foi possivel recuperar as portarias publicas!']);
        }
    }

    public function portariasPrivadas()
    {
        try {
            $portarias = DB::table('portarias')
                ->where('isPrivate', '=', 1)
                ->get();

            return response()->json($portarias, 200);
        } catch (\Throwable $err) {
            return response()->json($err, 500, ['mensagem' => 'Não foi possivel recuperar as portarias publicas!']);
        }
    }

    public function portariasPermanentes()
    {
        try {
            $portarias = DB::table('portarias')
                ->where('dataEncerramento', '=', null)
                ->get();

            return response()->json($portarias, 200);
        } catch (\Throwable $err) {
            return response()->json($err, 500, ['mensagem' => 'Não foi possivel recuperar as portarias publicas!']);
        }
    }
}
