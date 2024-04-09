<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <style>
        .container{
            background-color: #ffffff;
            width: 600px;
            max-width: 400px;
            border: 1px solid #cce7d080;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 15px;
            text-align: center; /* Centraliza todos os elementos */
        }

        .info{
            background-color: #fff;
            padding: 30px 50px;
            border: none;
            width: 300px;
            }
        
        .voltar{
            margin-bottom:15px;
            padding: 10px 25px;
            background-color: #24861a;
            color: #ffffff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .voltar {
            background-color: #226a19;
        }

    </style>
<body>
<div class="container">
    <h3>informações principais</h3>

    <div class="info">
        <p><strong>Nome:</strong>  {{$cliente['nome']}}</p>
        <p><strong>E-mail:</strong>  {{$cliente['email']}}</p>
        <p><strong>CPF:</strong>  {{$cliente['cpf']}}</p>
    </div>

    <form action="{{ route('cliente.index') }}" method="GET">
        <button class="voltar" type="submit">Voltar</button>
    </form>
</div>
</body>
</html>




