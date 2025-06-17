<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;
use App\Models\Presenca;
use Exception;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class PresencaController extends Controller
{
    public function index()
    {
        $clientes = Clientes::all();
        // CORREÇÃO: Carregar clientes soft-deletados no relacionamento
        $presencas = Presenca::with(['cliente' => function ($query) {
            $query->withTrashed(); // Inclui clientes soft-deletados
        }])->get();
        return view('presenca', compact('clientes', 'presencas'));
    }

    public function registrarEntrada(Request $request)
    {
        try {
            $request->validate([
                'cliente_id' => 'required|exists:clientes,id',
                'entrada' => 'required|date_format:Y-m-d\TH:i',
            ]);

            $existingPresenca = Presenca::where('cliente_id', $request->cliente_id)
                                        ->whereDate('entrada', Carbon::parse($request->entrada)->toDateString())
                                        ->whereNull('saida')
                                        ->first();

            if ($existingPresenca) {
                return redirect()->back()->withInput()->withErrors(['entrada' => 'Esta criança já possui uma entrada registrada para hoje sem saída.']);
            }

            Presenca::create([
                'cliente_id' => $request->cliente_id,
                'entrada' => $request->entrada,
            ]);

            return redirect()->route('presenca.index')->with('success', 'Entrada registrada com sucesso.');

        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (Exception $e) {
            \Log::error('Erro ao registrar entrada: ' . $e->getMessage() . ' - ' . $e->getTraceAsString());
            return redirect()->back()->withInput()->withErrors(['general_error' => 'Erro ao registrar entrada. Detalhe: ' . $e->getMessage()]);
        }
    }

    public function registrarSaida(Request $request)
    {
        try {
            $request->validate([
                'cliente_id' => 'required|exists:clientes,id',
                'saida' => 'required|date_format:Y-m-d\TH:i',
            ]);

            $presenca = Presenca::where('cliente_id', $request->cliente_id)
                ->whereNull('saida')
                ->latest('entrada')
                ->first();

            if (!$presenca) {
                return redirect()->back()->withInput()->withErrors(['saida' => 'Nenhuma entrada em aberto encontrada para esta criança.']);
            }

            if (Carbon::parse($request->saida)->lessThan(Carbon::parse($presenca->entrada))) {
                return redirect()->back()->withInput()->withErrors(['saida' => 'A hora de saída não pode ser anterior à hora de entrada.']);
            }

            $presenca->update(['saida' => $request->saida]);

            return redirect()->route('presenca.index')->with('success', 'Saída registrada com sucesso.');

        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (Exception $e) {
            \Log::error('Erro ao registrar saída: ' . $e->getMessage() . ' - ' . $e->getTraceAsString());
            return redirect()->back()->withInput()->withErrors(['general_error' => 'Erro ao registrar saída. Detalhe: ' . $e->getMessage()]);
        }
    }

    public function carregarPresencas($data)
    {
        try {
            $dataFormatada = Carbon::parse($data)->toDateString();

            // CORREÇÃO: Carregar clientes soft-deletados no relacionamento para a API
            $presencas = Presenca::with(['cliente' => function ($query) {
                $query->withTrashed(); // Inclui clientes soft-deletados
            }])
                ->whereDate('entrada', $dataFormatada)
                ->get();

            $formattedPresencas = $presencas->map(function($presenca) {
                return [
                    'id' => $presenca->id,
                    'cliente_id' => $presenca->cliente_id,
                    // Acessa o nome_crianca com fallback para 'Cliente Excluído'
                    'cliente_nome_crianca' => $presenca->cliente->nome_crianca ?? 'Cliente (Excluído)',
                    'entrada' => $presenca->entrada,
                    'saida' => $presenca->saida,
                ];
            });

            return response()->json($formattedPresencas);
        } catch (Exception $e) {
            \Log::error('Erro ao carregar presenças (API): ' . $e->getMessage() . ' - ' . $e->getTraceAsString());
            return response()->json(['error' => 'Erro interno do servidor ao carregar presenças. Detalhe: ' . $e->getMessage()], 500);
        }
    }
}
