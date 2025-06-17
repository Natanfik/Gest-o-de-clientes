<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    {{-- Garanta que este caminho para o CSS esteja correto --}}
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
<body>
    <div class="conteiner">
        <h2>Clientes:</h2>
        <div class="top-bar">
            <div class="left-actions">
                <form action="{{ route('cliente.create') }}" method="GET">
                    <input class="novo_cliente" type="submit" value=" + Incluir">
                </form>
                <a href="{{ route('presenca.index') }}" class="presenca">Presença</a>
            </div>
            <div class="right-actions">
                <form class="pesquisar" action="{{ route('cliente.index') }}" method="GET">
                    <input type="text" name="search" placeholder="Pesquisar..." value="{{ $search ?? '' }}">
                    <button type="submit">Pesquisar</button>
                </form>
            </div>
        </div>

        {{-- Mensagens de sucesso ou erro (Laravel Session) --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Exibição de erros de validação gerais --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Lista de Clientes --}}
        @forelse ($clientes as $cliente) {{-- Usando @forelse para lidar com lista vazia --}}
            <li>
                <a class="nomes">{{ $cliente->nome_crianca }}</a>
                
                <div class="actions-group">
                    <a href="{{ route('cliente.show', ['id' => $cliente->id]) }}" class="detalhes-btn">Detalhes</a>
                    
                    <form action="{{ route('cliente.edit', $cliente->id) }}" method="GET">
                        <input class="edit" type="submit" value="Editar">
                    </form>
                    
                    <form action="{{ route('cliente.destroy', $cliente->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');">
                        @csrf
                        @method('DELETE')
                        <input class="apagar" type="submit" value="Apagar">
                    </form>
                </div>
            </li>
        @empty
            {{-- Mensagem quando não há clientes --}}
            @if(isset($search) && !empty($search))
                <p>Nenhum cliente encontrado para a pesquisa "{{ $search }}".</p>
            @else
                <p>Nenhum cliente cadastrado. Comece adicionando um! 📝</p>
            @endif
        @endforelse

        {{-- LINKS DE PAGINAÇÃO --}}
        {{ $clientes->links() }}
    </div>
</body>
</html>

