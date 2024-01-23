<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnostico;
use App\Models\Consulta;
use App\Models\Paciente;
use Illuminate\Support\Facades\Log;

class DiagnosticosController extends Controller
{
    public function index()
    {
        $diagnosticos = Diagnostico::paginate(8);
        return view('diagnostico.index', compact('diagnosticos'));
    }

    public function create($consultaId)
    {
        // Buscar a consulta específica pelo ID
        $consulta = Consulta::find($consultaId);

        // Verificar se a consulta foi encontrada
        if (!$consulta) {
            // Tratar o caso em que a consulta não foi encontrada
            abort(404, 'Consulta não encontrada');
        }

        // Verificar se a consulta já possui um diagnóstico associado
        $diagnosticoExistente = Diagnostico::where('consulta_id', $consulta->id)->first();

        // Se já existir um diagnóstico, redirecionar para a página de visualização do diagnóstico existente
        if ($diagnosticoExistente) {
            return redirect('/consultaIndex?id=' . $diagnosticoExistente->id)
                ->with('error', 'Esta consulta já possui um diagnóstico associado.');
        }

        // Se não existir diagnóstico, continuar com a criação
        return view('diagnostico.create', compact('consulta'));
    }

    public function saveDiagnostico(Request $request)
    {
        $request->validate([
            'data_diagnostico' => 'required|date',
            'consulta_id' => 'required|exists:consultas,id',
            'descricao' => 'required|string',
            'observacoes' => 'nullable|string',
        ]);



        // Criação de um novo diagnóstico com base nos dados do formulário
        $diagnostico = new Diagnostico([
            'data_diagnostico' => $request->input('data_diagnostico'),
            'consulta_id' => $request->input('consulta_id'),
            'descricao' => $request->input('descricao'),
            'observacoes' => $request->input('observacoes'),
        ]);

        $diagnostico->save();

        // Buscar a consulta associada ao diagnóstico
        $consulta = Consulta::find($request->input('consulta_id'));

        // Redireciona para a página desejada após o salvamento
        return redirect()->route('prescricaoCreate', ['consultaId' => $consulta->id])->with('success', 'Diagnóstico cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $diagnostico = Diagnostico::with('consulta')->findOrFail($id);
        // Buscar todas as consultas para o dropdown
        $consultas = Consulta::all();
        return view('diagnostico.edit', compact('diagnostico', 'consultas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'data_diagnostico' => 'required|date',
            'descricao' => 'required|string',
            'observacoes' => 'nullable|string',
            'consulta_id' => 'required|exists:consultas,id',
        ]);

        $diagnostico = Diagnostico::findOrFail($id);
        $diagnostico->update($request->all());

        return redirect()->route('diagnosticoIndex')->with('success', 'Diagnóstico actualizado com sucesso.');
    }

    public function show($id)
    {
        $diagnostico = Diagnostico::with('consulta')->findOrFail($id);
        $consulta = $diagnostico->consulta; // Obtenha a consulta relacionada ao diagnóstico
        return view('diagnostico.view', compact('diagnostico', 'consulta'));
    }


    public function delete($id)
    {
        $diagnostico = Diagnostico::findOrFail($id);
        $diagnostico->delete();

        return redirect()->route('diagnosticoIndex')->with('successDelete', 'Diagnóstico excluído com sucesso.');
    }
}
