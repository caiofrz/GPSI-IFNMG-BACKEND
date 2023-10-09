<?php

namespace App\Http\Controllers;

use App\Models\Portaria;
use App\Models\ServidorPortaria;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortariaController extends Controller
{

    public function index()
    {
        $portarias = Portaria::all();
        if (!$portarias) {
            return response()->json($portarias, 404, ['mensagem' => 'Portarias não encontradas!']);
        }
        return response()->json($portarias, 200);
    }

    protected function show($numeroPortaria)
    {
        $portaria = Portaria::find($numeroPortaria);
        if (!$portaria) {
            return response()->json($portaria, 404, ['mensagem' => 'Portaria não encontrada!']);
        }
        return response()->json($portaria, 200);
    }

    public function store(Request $request)
    {

        $request->validate([
            'numeroPortaria' => ['required', 'integer'],
            'dataCriacao' => ['required', 'date'],
            'dataEncerramento' => ['date'],
            'descricao' => ['required', 'string'],
            'isPrivate' => ['required', "boolean"],
            'documento' => ['string'],
            'arquivo' => ['required']
        ]);


        try {
            // Upload do arquivo
            if ($request->hasFile('arquivo')) {
                try {
                    $extension = $request->file('arquivo')->getClientOriginalExtension();
                    $fileName = 'portaria-' . $request->numeroPortaria . ".{$extension}";
                    $path = $request->file('arquivo')->storeAs('portarias', $fileName);
                } catch (\Throwable $err) {
                    return response()->json($err, 500, ['mensagem' => 'Não foi possível fazer upload do documento!']);
                }
            } else {
                $path = null;
            }

            //o path guarda o caminho do arquivo no servidor
            $portaria = Portaria::create([
                'numeroPortaria' => $request->numeroPortaria,
                'dataCriacao' => $request->dataCriacao,
                'dataEncerramento' => $request->dataEncerramento,
                'descricao' => $request->descricao,
                'isPrivate' => $request->isPrivate,
                'arquivo' => $path,
            ]);

            try {
                $membrosExternos = $request->pessoasExternas;
                $servidoresMembros = $request->servidores;

                if (!empty($servidoresMembros)) {
                    foreach ($servidoresMembros as $servidor => $membro) {
                        if (User::find($membro['matriculaSiape'])) {
                            $portariaServidor = ServidorPortaria::create([
                                'numeroPortaria' => $request->numeroPortaria,
                                'matriculaSiape' => $membro['matriculaSiape'],
                            ]);
                        }
                    }
                }

                if (!empty($membrosExternos)) {
                    foreach ($membrosExternos as $externo => $membro) {
                        if (User::find($membro['id'])) {
                            $portariaExterno = ServidorPortaria::create([
                                'numeroPortaria' => $request->numeroPortaria,
                                'id' => $membro['id'],
                            ]);
                        }
                    }
                }
            } catch (QueryException $err) {
                return response()->json($err, 500, ['mensagem' => 'Não foi possível cadastrar os membros da portaria!']);
            }

            return response()->json($portaria, 201);
        } catch (\Throwable $err) {
            return response()->json($err, 500, ['mensagem' => 'Portaria não pode ser criada!']);
        }
    }

    public function update(Request $request, $numeroPortaria)
    {
        $request->validate([
            'numeroPortaria' => ['required', 'integer'],
            'dataCriacao' => ['required', 'date'],
            'dataEncerramento' => ['date'],
            'descricao' => ['required', 'string'],
            'isPrivate' => ['required', "boolean"],
            'documento' => ['string'],
            'arquivo' => ['required']
        ]);

        $portaria = Portaria::find($numeroPortaria);
        if (!$portaria) {
            return response()->json($portaria, 404, ['mensagem' => 'Portaria não encontrada!']);
        }

        try {
            // Upload do arquivo
            if ($request->hasFile('arquivo')) {
                try {
                    $extension = $request->file('arquivo')->getClientOriginalExtension();
                    $fileName = 'portaria-' . $request->numeroPortaria . ".{$extension}";
                    $path = $request->file('arquivo')->storeAs('portarias', $fileName);
                } catch (\Throwable $err) {
                    return response()->json($err, 500, ['mensagem' => 'Não foi possível fazer upload do documento!']);
                }
            }

            $portaria->numeroPortaria = $request->numeroPortaria;
            $portaria->dataCriacao = $request->dataCriacao;
            $portaria->dataEncerramento = $request->dataEncerramento;
            $portaria->descricao = $request->descricao;
            $portaria->isPrivate = $request->isPrivate;
            $portaria->arquivo = $path; //o path guarda o caminho do arquivo no servidor
            $portaria->update();

            try {
                $membrosExternos = $request->pessoasExternas;
                $servidoresMembros = $request->servidores;

                if (!empty($servidoresMembros)) {
                    foreach ($servidoresMembros as $servidor => $membro) {
                        if (User::find($membro['matriculaSiape'])) {
                            $portariaServidor = ServidorPortaria::create([
                                'numeroPortaria' => $request->numeroPortaria,
                                'matriculaSiape' => $membro['matriculaSiape'],
                            ]);
                        }
                    }
                }

                if (!empty($membrosExternos)) {
                    foreach ($membrosExternos as $externo => $membro) {
                        if (User::find($membro['id'])) {
                            $portariaExterno = ServidorPortaria::create([
                                'numeroPortaria' => $request->numeroPortaria,
                                'id' => $membro['id'],
                            ]);
                        }
                    }
                }

            } catch (QueryException $err) {
                return response()->json($err, 500, ['mensagem' => 'Não foi possível cadastrar os membros da portaria!']);
            }
            return response()->json($portaria, 201, ['mensagem' => 'Portaria atualizada com sucesso!']);
        } catch (\Throwable $err) {
            return response()->json($err, 500, ['mensagem' => 'Não foi possivel editar os dados da portaria!']);
        }
    }

    public function delete($numeroPortaria)
    {
        try {
            $portaria = Portaria::find($numeroPortaria);
            if (!$portaria) {
                return response()->json($portaria, 404, ['mensagem' => 'Portaria não encontrada!']);
            }
            $portaria->delete();
            return response()->json(null, 200, ['mensagem' => 'Portaria deletada com sucesso']);
        } catch (QueryException $err) {
            return response()->json($err, 404, ['mensagem' => 'Portaria não pode ser deletada!']);
        }
    }

    public function getDocumento($numeroPortaria)
    {
        try {
            $portaria = Portaria::find($numeroPortaria);
            $arquivo = Storage::path($portaria->arquivo);
            return response()->file($arquivo);
        } catch (\Throwable $err) {
            return response()->json($err, 204, ['mensagem' => 'Arquivo não existe!']);
        }
    }
}
