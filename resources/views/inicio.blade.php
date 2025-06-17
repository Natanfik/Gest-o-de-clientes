
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
        }

        .lista {
            padding: 15px;
            background-color: #5e7e46;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px; /* Adicionado um espaço entre o h2 e o botão */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Lista de Clientes</h2>
        <form action="{{ route('cliente.index') }}" method="GET">
            <button class="lista">Acessar</button>
        </form>
    </div>
</body>
</html>
