<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <style>
        /* Define box-sizing para todos os elementos para um controle de layout mais previsível */
        *, *::before, *::after {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            /* Imagem de fundo translúcida */
            background-image: url("https://img.freepik.com/vetores-gratis/fundo-de-solsticio-de-inverno-em-aquarela_23-2149177804.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex; /* Utiliza flexbox para centralizar o container principal */
            align-items: center; /* Centraliza verticalmente o container */
            justify-content: center; /* Centraliza horizontalmente o container */
            padding: 20px; /* Adiciona um preenchimento para as bordas em telas menores */
        }

        .container-principal {
            background-color: rgba(255, 255, 255, 0.4); /* Fundo branco translúcido */
            backdrop-filter: blur(8px); /* Efeito de desfoque no fundo */
            max-width: 1000px;
            width: 100%; /* Garante que o container ocupe a largura total disponível até o max-width */
            margin: auto; /* Centraliza o container */
            padding: 30px;
            border-radius: 16px; /* Cantos arredondados para o container principal */
            box-shadow: 0 4px 12px rgba(0,0,0,0.3); /* Sombra suave */
            text-align: center;
        }

        .container-principal h2 {
            font-size: 28px;
            margin-bottom: 30px;
            color: #333;
        }

        /* Container para as divs lado a lado */
        .blocos-lado-a-lado {
            display: flex;
            justify-content: center; /* Centraliza os blocos dentro do container flex */
            gap: 20px; /* Espaçamento entre os blocos */
            flex-wrap: wrap; /* Permite que os blocos quebrem para a linha seguinte em telas menores */
            align-items: flex-start; /* Alinha os itens ao topo se tiverem alturas diferentes */
        }

        /* Estilo para os blocos individuais (Responsável e Criança) */
        .bloco {
            flex: 1; /* Permite que os blocos cresçam e encolham igualmente */
            min-width: 300px; /* Largura mínima antes de quebrar para a próxima linha */
            max-width: calc(50% - 10px); /* Largura máxima para dois blocos lado a lado, considerando o gap */
            background-color: rgba(255, 255, 255, 0.6); /* Fundo translúcido para os blocos */
            padding: 20px;
            border-radius: 14px; /* Cantos arredondados para os blocos */
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* Títulos dos blocos */
        .bloco h3 {
            margin-bottom: 15px;
            color: #222;
        }

        /* Estilo para campos de input, select e textarea */
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 14px;
            background-color: rgba(255, 255, 255, 0.9); /* Fundo levemente translúcido para campos */
        }

        /* Botão "Avançar" */
        button {
            width: 100%;
            padding: 12px;
            margin-top: 25px;
            background-color: #4caf50; /* Cor de fundo verde */
            color: white;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 12px; /* Cantos arredondados para o botão */
            cursor: pointer;
            transition: background 0.3s ease; /* Transição suave ao passar o mouse */
        }

        button:hover {
            background-color: #388e3c; /* Cor de fundo mais escura ao passar o mouse */
        }

        /* Botão/Link "Cancelar" */
        .cancelar {
            display: block;
            text-align: center;
            margin-top: 15px;
            padding: 10px;
            background-color: white;
            border: 1px solid #aaa;
            border-radius: 10px; /* Cantos arredondados para o botão cancelar */
            color: #444;
            text-decoration: none;
            transition: border 0.3s ease;
        }

        .cancelar:hover {
            border-color: #000;
        }

        /* Media query para telas menores (responsividade) */
        @media (max-width: 768px) {
            .blocos-lado-a-lado {
                flex-direction: column; /* Empilha os blocos verticalmente */
                align-items: center; /* Centraliza os blocos quando empilhados */
            }

            .bloco {
                max-width: 100%; /* Ocupa a largura total em telas pequenas */
            }
        }
    </style>
</head>
<body>
    <form action="<?php echo e(route('cliente.storeDadosPessoais')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="container-principal">
            <h2>🎉 Cadastro Origens</h2>

            
            <?php if($errors->any()): ?>
                <div class="alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="blocos-lado-a-lado">
                <!-- Responsável -->
                <div class="bloco bloco-responsavel">
                    <h3>👨‍👩‍👧 Responsável</h3>
                    <input type="text" name="nome" placeholder="Nome Completo" value="<?php echo e(old('nome')); ?>">
                    <?php $__errorArgs = ['nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <input type="text" name="email" placeholder="E-mail" value="<?php echo e(old('email')); ?>">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <input type="date" name="nascimento" placeholder="Nascimento" value="<?php echo e(old('nascimento')); ?>">
                    <?php $__errorArgs = ['nascimento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <input type="text" name="cpf" placeholder="CPF" value="<?php echo e(old('cpf')); ?>">
                    <?php $__errorArgs = ['cpf'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <input type="text" name="endereço" placeholder="endereço" value="<?php echo e(old('endereço')); ?>">
                    <?php $__errorArgs = ['cpf'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <input type="text" name="telefone" placeholder="Telefone" value="<?php echo e(old('telefone')); ?>"> 
                    <?php $__errorArgs = ['telefone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Criança -->
                <div class="bloco bloco-crianca">
                    <h3>🧒 Criança</h3>
                    <input type="text" name="nome_crianca" placeholder="Nome da criança" value="<?php echo e(old('nome_crianca')); ?>">
                    <?php $__errorArgs = ['nome_crianca'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <input type="date" name="data_nascimento_crianca" placeholder="Nascimento" value="<?php echo e(old('data_nascimento_crianca')); ?>">
                    <?php $__errorArgs = ['data_nascimento_crianca'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <select name="genero_crianca">
                        <option value="">Selecione o gênero</option>
                        <option value="Masculino" <?php echo e(old('genero_crianca') == 'Masculino' ? 'selected' : ''); ?>>Masculino</option>
                        <option value="Feminino" <?php echo e(old('genero_crianca') == 'Feminino' ? 'selected' : ''); ?>>Feminino</option>
                        <option value="Outro" <?php echo e(old('genero_crianca') == 'Outro' ? 'selected' : ''); ?>>Outro</option>
                    </select>
                    <?php $__errorArgs = ['genero_crianca'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <textarea name="observacoes_crianca" placeholder="Observações"><?php echo e(old('observacoes_crianca')); ?></textarea>
                    <?php $__errorArgs = ['observacoes_crianca'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <button type="submit">🚀 Avançar</button>
            <a class="cancelar" href="<?php echo e(route('cliente.index')); ?>">Cancelar</a>
        </div>
    </form>
</body>
</html>
<?php /**PATH D:\laragon\www\Origens\resources\views/cadastro.blade.php ENDPATH**/ ?>