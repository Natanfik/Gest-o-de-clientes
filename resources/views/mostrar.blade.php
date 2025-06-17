<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Cliente</title>
    <style>
        /* Resete básico para garantir controle total do layout */
        *, *::before, *::after {
            box-sizing: border-box; /* Inclui padding e border na largura/altura do elemento */
        }

        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-image: url("https://img.freepik.com/vetores-gratis/fundo-de-solsticio-de-inverno-em-aquarela_23-2149177804.jpg");
            background-repeat: no-repeat;
            background-size: cover; /* Garante que a imagem de fundo cubra toda a área */
            background-position: center;
            min-height: 100vh; /* Ocupa a altura total da viewport */
            display: flex; /* Transforma o body em um container flex para centralizar seu conteúdo */
            justify-content: center; /* Centraliza horizontalmente */
            align-items: center; /* Centraliza verticalmente */
            padding: 20px; /* Adiciona um espaço nas bordas em telas pequenas */
        }

        /* Container principal que envolve todo o conteúdo visível */
        .main-show-container {
            background-color: rgba(255, 255, 255, 0.4); /* Fundo branco translúcido */
            backdrop-filter: blur(8px); /* Efeito de desfoque no fundo */
            max-width: 1000px; /* Largura máxima para o conteúdo */
            width: 100%; /* Ocupa a largura total disponível até o max-width */
            margin: auto; /* Centraliza o container na página */
            padding: 30px;
            border-radius: 16px; /* Cantos arredondados */
            box-shadow: 0 4px 12px rgba(0,0,0,0.3); /* Sombra suave */
            text-align: center; /* Centraliza o título principal e o botão "Voltar" */
        }

        .main-show-container h1 {
            font-size: 32px;
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }

        /* Container Flexbox para os dois blocos de informação (Responsável e Criança) */
        .content-grid {
            display: flex; /* Ativa o Flexbox para alinhar os itens lado a lado */
            flex-wrap: wrap; /* Permite que os itens quebrem para a próxima linha em telas menores */
            justify-content: space-between; /* Distribui o espaço entre os itens, empurrando-os para as bordas */
            gap: 20px; /* Espaçamento entre os blocos */
            margin-bottom: 30px; /* Espaço abaixo dos blocos antes do botão "Voltar" */
        }

        /* Estilo para cada bloco individual (Dados do Responsável, Dados da Criança) */
        .info-block {
            flex: 1 1 calc(50% - 10px); /* Garante que cada bloco ocupe quase 50% da largura, deixando espaço para o gap */
            /* flex-grow: 1, flex-shrink: 1, flex-basis: calc(50% - 10px) */
            min-width: 300px; /* Largura mínima antes de os blocos quebrarem a linha */
            background-color: rgba(255, 255, 255, 0.6); /* Fundo translúcido para os blocos */
            padding: 20px;
            border-radius: 14px; /* Cantos arredondados para os blocos */
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: left; /* Alinha o texto dentro dos blocos à esquerda */
        }

        /* Títulos dentro dos blocos de informação */
        .info-block h2, .info-block h3 {
            color: #222;
            margin-top: 0;
            margin-bottom: 15px;
            text-align: center; /* Centraliza os títulos dentro dos blocos */
        }

        /* Parágrafos e texto em negrito dentro dos blocos de informação */
        .info-block p {
            margin-bottom: 8px;
            color: #333;
            line-height: 1.5;
        }

        .info-block strong {
            color: #555;
        }

        /* Estilo para a lista de detalhes do pacote, se houver */
        .package-details {
            margin-top: 15px;
            border-top: 1px solid rgba(0,0,0,0.1); /* Linha divisória */
            padding-top: 15px;
        }

        /* Estilo para o botão "Voltar" */
        .voltar {
            margin-top: 20px; /* Espaçamento acima do botão */
            padding: 12px 30px;
            background-color: #4caf50; /* Cor verde */
            color: #ffffff;
            border: none;
            border-radius: 10px; /* Cantos arredondados */
            cursor: pointer;
            transition: background-color 0.3s ease; /* Transição suave ao passar o mouse */
            font-size: 16px;
            font-weight: bold;
            display: inline-block; /* Permite centralização via text-align no pai */
            text-decoration: none; /* Remove sublinhado se for um link (<a>) */
        }
        .voltar:hover {
            background-color: #388e3c; /* Cor verde mais escura ao passar o mouse */
        }

        /* Media Query para responsividade: empilha em telas menores */
        @media (max-width: 768px) {
            .content-grid {
                flex-direction: column; /* Empilha os blocos verticalmente */
                align-items: center; /* Centraliza os blocos quando empilhados */
            }
            .info-block {
                max-width: 100%; /* Ocupa a largura total em telas pequenas */
                width: 100%; /* Garante que ocupe 100% da largura do pai */
            }
            .main-show-container {
                padding: 20px; /* Reduz o padding em telas menores para melhor aproveitamento do espaço */
            }
        }
    </style>
</head>
<body>
    <div class="main-show-container">
        <h1> Detalhes do Cliente ✨</h1>

        @if (!empty($cliente))
            <div class="content-grid">

                <div class="info-block">
                    <h2>👨‍👩‍👧 Dados do Responsável</h2>
                    <p><strong>Nome:</strong> {{ $cliente->nome }}</p>
                    <p><strong> Email:</strong> {{ $cliente->email }}</p>
                    <p><strong> Data de Nascimento:</strong> {{ $cliente->nascimento }}</p>
                    <p><strong> CPF:</strong> {{ $cliente->cpf }}</p>
                    <p><strong> Endereço:</strong> {{ $cliente->endereço ?? 'Não informado' }}</p>
                    <p><strong> Contato:</strong> {{ $cliente->numero ?? 'Não informado' }}</p>

                    @if ($cliente->valores->isNotEmpty())
                        <h3>🎁 Detalhes do Pacote</h3>
                        <div class="package-details">
                            @foreach ($cliente->valores as $valor)
                                <p><strong> Tipo:</strong> {{ $valor->tipo }}</p>
                                <p><strong> Descrição:</strong> {{ $valor->descricao }}</p>
                                <p><strong> Valor:</strong> {{ $valor->valor }}</p>
                            @endforeach
                        </div>
                    @else
                        <a href="{{ route('cliente.pacotes', $cliente->id) }}" class="pacote">Adicionar Pacote 🎁</a> 😔</p>
                    @endif
                </div>

                <div class="info-block">
                    <h2>🧒 Dados da Criança</h2>
                    <p><strong>Nome:</strong> {{ $cliente->nome_crianca }}</p>
                    <p><strong>Data de Nascimento:</strong> {{ $cliente->data_nascimento_crianca }}</p>
                    <p><strong>Gênero:</strong> {{ $cliente->genero_crianca }}</p>
                    <p><strong>Observações:</strong> {{ $cliente->observacoes_crianca ?? 'Não informado' }}</p>
                </div>

            </div>
        @else
            <p>Nenhum dado de cliente disponível. 🧐</p>
        @endif

        <form action="{{ route('cliente.index') }}" method="GET">
            <button class="voltar" type="submit"> Voltar</button>
        </form>

    </div>
</body>
</html>
