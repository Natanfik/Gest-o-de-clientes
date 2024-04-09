<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClienteControladora extends Controller
{

    private $clientes = [
        ['id'=>1, 'nome'=>'Sansumg', 'email'=>'nome@exemplo.com', 'cpf'=>'12345678912'],
        ['id'=>2, 'nome'=>'joao', 'email'=>'nome@exemplo.com', 'cpf'=>'12345678912'],
        ['id'=>3, 'nome'=>'pedro', 'email'=>'nome@exemplo.com', 'cpf'=>'12345678912'],
        ['id'=>4, 'nome'=>'juliane', 'email'=>'nome@exemplo.com', 'cpf'=>'12345678912']
     ];

    public function __construct() {
        $clientes = session('clientes');
        if (!isset($clientes))
            session(['clientes' => $this->clientes]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = session('clientes'); // Supondo que você tenha uma lista de clientes na sessão
        return view('lista')->with('clientes', $clientes);
    
    }

    /**
     * Show the form for creating a new resource.
     */
    private function buscar($id, $clientes) {
        foreach ($clientes as $index => $cliente) {
            if ($cliente['id'] === $id) {
                return echo $index;
            }
        }
        return null; // Retorna null se o cliente com o ID especificado não for encontrado
    }

    public function create()
    {
        return view('cadastro');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $clientes = session('clientes');
        $id = end($clientes)['id'] + 1;
        $nome = $request->nome;
        $email = $request->email;
        $cpf = $request->cpf;
        $dados = ["id"=>$id, "nome"=>$nome, "email"=>$email, "cpf"=>$cpf ];
        $clientes[] = $dados;
        session(['clientes' => $clientes]);
        return redirect() -> route('cliente.index');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $clientes = session('clientes');
        $index =  $this->getIndex($id, $clientes);
        $cliente = $clientes [$index];
        return view('mostrar', compact(['cliente']));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $clientes = session('clientes');
        $index =  $this->getIndex($id, $clientes);
        $cliente = $clientes [$index];
        return view('editar', compact(['cliente']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $clientes = session('clientes');
        $index =  $this->getIndex($id, $clientes);
        $clientes [$index]['nome']=$request->nome;
        $clientes [$index]['email']=$request->email;
        $clientes [$index]['cpf']=$request->cpf;
        session(['clientes' => $clientes]);
        return redirect() -> route('cliente.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $clientes = session('clientes');
        $index = $this->getIndex($id, $clientes);
        array_splice($clientes, $index, 1);
        session(['clientes' => $clientes]);
        return redirect() -> route('cliente.index');

    }

    private function getIndex($id, $clientes) {
        $ids = array_column($clientes, 'id');
        $index = array_search($id, $ids);
        return $index;
    }
}