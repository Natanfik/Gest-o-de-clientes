<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <style>

        .login-container {
                background-color: rgba(0,0,0,0.5);
                width: 400px;
                align-items: center;
                margin: 0 auto; 
                max-width: 600px;
                border:1px solid #cce7d080;
                border-radius: 4px;
                box-shadow: 20px 20px 34px #000800;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }   

        .login-container h2 {
            text-align: center;
        }


        .login-container input,
        .login-container textarea,
        .login-container button {
            display: block;
            margin: 10px 0;
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;

        }

        .login{
            margin: 0 auto; 
            max-width: 600px;
        }
        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        

        #login-form {
            display: flex;
            flex-direction: column;
        }
        
        #login-form input {
            width:93%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #c2bfbf;
            border-radius: 5px;

        }

        #login-form input:hover {
            border: 1px solid #8ca777
        }
        
        #login-form button {
        
            padding: 10px;
            background-color: #5e7e46;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <form action="{{ route('cliente.store') }}" method="POST">
        <div class="login-container">
            <h2>Cadastrar Cliente</h2>
            <div id="login-form">
                @csrf
                <input type="text" name="nome" placeholder="Nome Completo">
                <input type="text" name="email" placeholder="E-mail">
                <input type="text" name="cpf" placeholder="CPF">
                <button type="submit" value="Enviar">Enviar</button>
            </div>
        </div>
    </form>

    <script>
        // Função para formatar CPF com pontos e traço
        function formatarCPF(cpf) {
            // Verifica se o CPF está no formato padrão (apenas números)
            if (/^\d{11}$/.test(cpf)) {
                // Adiciona os pontos e traço
                return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            } else {
                return cpf; // Retorna o CPF sem formatação caso não esteja no formato padrão
            }
        }
        
        // Chama a função formatarCPF quando o documento HTML for carregado para formatar o CPF inicialmente
        window.onload = function() {
            var cpfInput = document.querySelector('input[name="cpf"]');
            cpfInput.addEventListener('keyup', function() {
                this.value = formatarCPF(this.value);
            });
        };
    </script>
</body>
</html>




