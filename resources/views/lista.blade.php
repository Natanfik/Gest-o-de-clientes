
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .conteiner {
            background-color: #ffffff;
            width: 600px;
            max-width: 600px;
            border: 1px solid #cce7d080;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 15px;
            text-align: center; /* Centraliza todos os elementos */
        }
        h2 {
            color: #333333;
        }
        a {
            margin-right:100px;
            text-decoration: none;
            color: #333333;

        }
        a:hover {
            text-decoration: underline;
        }

        .nomes{
            font-weight:600;
            width:10%;
            text-decoration: none;
            color: #333333;
            float:left;
        }

        li {
            
            list-style-type: none;
            background-color: #ffffff;
            margin-bottom: 10px;
            padding:40px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        form {
            display: inline;
        }
        .novo_cliente {
            margin-bottom:15px;
            padding: 10px 10px;
            background-color: #24861a;
            color: #ffffff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .novo_cliente:hover {
            background-color: #226a19;
        }
        .apagar {
 
            padding: 5px 10px;
            background-color: #ff6347;
            color: #ffffff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            float:right;
            margin-right:3px;

        }
        .apagar:hover {
            background-color: #d23e30;
        }
    </style>
</head>
<body>
    <div class="conteiner">
        <h2>Lista de clientes: </h2>
        <form action="{{ route('cliente.create') }}" method="GET">
            <button class="novo_cliente" type="submit">Novo Cliente</button>
        </form>
            @foreach($clientes as $c)
                <li>
                    <a class="nomes">{{ $c['nome'] }}</a>
                    <a href="{{ route('cliente.edit', $c['id'] )}}"> Editar</a>
                    <a href="{{ route('cliente.show', $c['id'] )}}"> Info</a>
                 
                    <form action="{{ route('cliente.destroy', $c['id'] )}}" method="POST" onsubmit="return confirm('Tem certeza que deseja apagar este cliente?')">
                        @csrf
                        @method('DELETE')
                        <input class="apagar" type="submit" value="Apagar">
                    </form>
                </li> 
            @endforeach   
    </div>
</body>
</html>

