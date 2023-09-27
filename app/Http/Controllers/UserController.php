<?php

namespace App\Http\Controllers;

use App\Models\Portaria;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        if (!$users) {
            return response()->json($users, 404, ['mensagem' => 'Servidor não encontrado!']);
        }
        return response()->json($users, 200);
    }


    protected function show($matriculaSiape)
    {

        $user = User::find($matriculaSiape);
        if (!$user) {
            return response()->json($user, 404, ['mensagem' => 'Servidor não encontrado!']);
        }
        return response()->json($user, 200);
    }

    protected function update(Request $request, $matriculaSiape)
    {
        try {
            $user = User::find($matriculaSiape);
            if (!$user) {
                return response()->json($user, 404, ['mensagem' => 'Servidor não encontrado!']);
            }
            $user->matriculaSiape = $request->matriculaSiape;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->cargo = $request->cargo;
            $user->isAdmin = $request->isAdmin;
            $user->isSuperAdmin = $request->isSuperAdmin;
            $user->foto = $request->foto;
            $user->update();
            return response()->json($user, 201, ['mensagem' => 'Servidor atualizado com sucesso!']);
        } catch (QueryException $err) {
            return response()->json($err, 404, ['mensagem' => 'Não foi possivel editar os dados do servidor!!']);
        }
    }

    public function delete($matriculaSiape)
    {
        try {
            $user = User::find($matriculaSiape);
            if (!$user) {
                return response()->json($user, 404, ['mensagem' => 'Servidor não encontrado!']);
            }
            $user->delete();
            return response()->json(null, 200, ['mensagem' => 'Servidor deletado com sucesso']);
        } catch (QueryException $err) {
            return response()->json($err, 404, ['mensagem' => 'Servidor não pode ser deletado!']);
        }
    }

    public function minhasPortarias($matriculaSiape)
    {
        try {
            $user = User::find($matriculaSiape);
            if (!$user) {
                return response()->json($user, 404, ['mensagem' => 'Servidor não encontrado!']);
            }
            $portarias = DB::table('portarias')
            ->join('servidor_portarias', 'portarias.numeroPortaria', 'servidor_portarias.numeroPortaria')
            ->select()
            ->where('servidor_portarias.matriculaSiape', '=', $matriculaSiape)
            ->orderBy('dataCriacao', 'DESC')
            ->get();

            return response()->json($portarias, 200,);
        } catch (QueryException $err) {
            return response()->json($err, 404, ['mensagem' => 'Portarias não encontradas!']);
        }
    }
}
