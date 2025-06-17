<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;
use App\Models\Valor;
use Illuminate\Support\Facades\Log; // Corrigir importação do Log

class ClienteControladora extends Controller
{
   public function index(Request $request)
    {
        $search = $request->input('search');
        // Define quantos clientes por página você quer
        $perPage = 10; // Exemplo: 10 clientes por página

        $query = Clientes::query(); // Inicia uma nova consulta

        if ($search !== null) {
           
            $query->where('nome', 'like', '%' . $search . '%')
                  ->orWhere('nome_crianca', 'like', '%' . $search . '%');
        }

        // Aplica a paginação ao resultado da query
        $clientes = $query->paginate($perPage);

        return view('index', ['clientes' => $clientes, 'search' => $search]);
    }

    public function create()
    {
        return view('cadastro');
    }

    public function pacotes(string $id)
    {
        $cliente = Clientes::findOrFail($id);
        return view('pacotes', compact('cliente'));
    }

    public function storePacotes(Request $request)
    {
        // Validar os campos do formulário
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id', // O ID do cliente é agora um campo obrigatório
            'pacote' => 'required|string',
            'quantidade_mes' => 'required_if:pacote,Mensalista|string',
            'quantidade_semanal' => 'required_if:pacote,semanal|string',
            'dia_semana' => 'required_if:pacote,Diária|string',
            'quantidade_hora' => 'required_if:pacote,Passaporte hora|string',
            // O campo possui_irmao agora espera um inteiro (0, 1, 2, etc.)
            'possui_irmao' => 'nullable|integer', // Alterado para integer para aceitar 0, 1, 2
        ]);

        try {
            // OBTER O CLIENTE EXISTENTE (NÃO CRIAR UM NOVO)
            $cliente = Clientes::findOrFail($validated['cliente_id']);

            // Determinar o pacote selecionado com base nos critérios
            $pacoteSelecionado = null;
            if ($validated['pacote'] === 'Mensalista' && isset($validated['quantidade_mes'])) {
                $pacoteSelecionado = Valor::where('tipo', 'Mensalista')
                    ->where('descricao', 'like', '%' . $validated['quantidade_mes'] . '%')
                    ->first();
            } elseif ($validated['pacote'] === 'semanal' && isset($validated['quantidade_semanal'])) {
                $pacoteSelecionado = Valor::where('tipo', 'semanal')
                    ->where('descricao', 'like', '%' . $validated['quantidade_semanal'] . '%')
                    ->first();
            } elseif ($validated['pacote'] === 'Passaporte hora' && isset($validated['quantidade_hora'])) {
                $pacoteSelecionado = Valor::where('tipo', 'Passaporte hora')
                    ->where('descricao', 'like', '%' . $validated['quantidade_hora'] . '%')
                    ->first();
            } elseif ($validated['pacote'] === 'Diária' && isset($validated['dia_semana'])) {
                $pacoteSelecionado = Valor::where('tipo', 'Diária')
                    ->where('descricao', 'like', '%' . $validated['dia_semana'] . '%')
                    ->first();
            } elseif ($validated['pacote'] === 'Hora avulsa') {
                // Se "Hora avulsa" não tem sub-opções, busque por tipo apenas
                $pacoteSelecionado = Valor::where('tipo', 'Hora avulsa')->first();
            }


            if ($pacoteSelecionado) {
                // Associar o pacote ao cliente EXISTENTE
                // A sua relação belongsToMany 'valores' precisa de cliente_id e valor_id na tabela pivot.
                // A linha abaixo fará a inserção na tabela pivot.
                $cliente->valores()->attach($pacoteSelecionado->id);
                // Se a tabela pivot 'cliente_valor' tiver uma coluna extra 'crianca_id' que armazena o id do cliente:
                // $cliente->valores()->attach($pacoteSelecionado->id, ['crianca_id' => $cliente->id]);
                // Mas geralmente, a FK do cliente já é passada implicitamente pelo attach.

            } else {
                return redirect()->back()->withInput()->withErrors(['message' => 'Pacote não encontrado com as opções selecionadas.']);
            }

            // Atualizar o campo possui_irmao no cliente EXISTENTE
            // Convertendo para booleano ou mantendo o número (depende do tipo da sua coluna possui_irmao no DB)
            // Se possui_irmao é boolean no DB:
            // $cliente->possui_irmao = (bool)($validated['possui_irmao'] ?? false);
            // Se possui_irmao é um INTEGER no DB para contar irmãos:
            $cliente->possui_irmao = $validated['possui_irmao'] ?? 0; // Se null, define como 0
            $cliente->save(); // Salva a atualização do campo possui_irmao no cliente existente

            // Redirecionar para a página de sucesso
            return redirect()->route('cliente.index')->with('success', 'Pacote associado com sucesso ao cliente.');

        } catch (ValidationException $e) {
            // Captura erros de validação e redireciona com mensagens
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            // Logar a exceção
            Log::error('Erro ao associar pacote: ' . $e->getMessage() . ' - ' . $e->getTraceAsString());
            // Retornar com mensagem de erro em caso de exceção
            return redirect()->back()->withInput()->withErrors(['message' => 'Erro ao associar o pacote: ' . $e->getMessage()]);
        }
    }
    
   public function storeDadosPessoais(Request $request)
    {
        // Validação dos campos do formulário
        $validated = $request->validate([
            // dados responsável
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clientes,email', // Adicionado unique para emails
            'cpf' => 'required|string|max:14|unique:clientes,cpf', // Adicionado unique para CPFs
            'nascimento' => 'required|date', // 'date' para validação de data
            'telefone' => 'required|string|max:255', // Campo 'telefone' validado

            // dados crianca
            'nome_crianca' => 'required|string|max:255',
            'data_nascimento_crianca' => 'required|date', // 'date' para validação de data
            'genero_crianca' => 'required|string|max:255',
            'observacoes_crianca' => 'nullable|string|max:255', // 'nullable' se for opcional
        ]);

        try {
            // Instanciar o Model Clientes
            $cliente = new Clientes(); // Usar 'Clientes' (com 's')

            // Atribuir os dados validados aos campos do Model
            // dados responsável
            $cliente->nome = $request->input('nome');
            $cliente->cpf = $request->input('cpf');
            $cliente->email = $request->input('email');
            $cliente->nascimento = $request->input('nascimento');
            $cliente->numero= $request->input('telefone'); // Atribuindo o campo 'telefone'
            $cliente->endereço= $request->input('endereço');
            // dados crianca
            $cliente->nome_crianca = $request->input('nome_crianca');
            $cliente->data_nascimento_crianca = $request->input('data_nascimento_crianca');
            $cliente->genero_crianca = $request->input('genero_crianca');
            $cliente->observacoes_crianca = $request->input('observacoes_crianca');

            $cliente->save(); // Mover o save() para dentro do bloco try

            // Redirecionar para a página de sucesso
            return redirect()->route('cliente.index')->with('success', 'Cliente cadastrado com sucesso.');

        } catch (\Exception $e) {
            // Logar a exceção para depuração
            Log::error('Erro ao cadastrar o cliente: ' . $e->getMessage() . ' - ' . $e->getTraceAsString());
            // Retornar com mensagem de erro em caso de exceção
            return redirect()->back()->withInput()->withErrors(['message' => 'Erro ao cadastrar o cliente: ' . $e->getMessage()]);
        }
    }



    public function edit(string $id)
    {
        $cliente = Clientes::findOrFail($id);
        return view('editar', compact('cliente'));
    }

    public function update(Request $request, string $id)
    {
        $cliente = Clientes::findOrFail($id);
        $cliente->update($request->all());
        return redirect()->route('cliente.index');
    }

    public function show($id)
    {
        // Buscar o cliente pelo ID e carregar os pacotes associados
        $cliente = Clientes::with('valores')->findOrFail($id);
        return view('mostrar', compact('cliente'));
    }

    public function destroy($id)
    {
        $cliente = Clientes::findOrFail($id);
        $cliente->delete();
        return redirect()->route('cliente.index');
    }
}
