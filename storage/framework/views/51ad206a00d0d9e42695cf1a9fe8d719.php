<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Pacote</title>
    
    <link rel="stylesheet" href="<?php echo e(asset('css/cadastro.css')); ?>">
    <style>
        /* Estilos básicos para mensagens de erro */
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 8px;
            text-align: left;
        }
        .alert-danger ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .error-message {
            color: #e3342f;
            font-size: 0.875em;
            margin-top: 5px;
            display: block;
        }

        /* Estilo para centralizar o formulário, similar ao seu cadastro.css */
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-image: url("https://img.freepik.com/vetores-gratis/fundo-de-solsticio-de-inverno-em-aquarela_23-2149177804.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container { /* Mantendo o nome da sua classe para o container principal do formulário */
            background-color: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(8px);
            max-width: 600px; /* Ajuste a largura conforme necessário */
            width: 100%;
            margin: auto;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            text-align: center;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 15px; /* Espaçamento entre os elementos */
        }

        .login-container h2 {
            font-size: 28px;
            margin-bottom: 30px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin: 0; /* Remover margens extras para controlar com gap */
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 14px;
            background-color: rgba(255, 255, 255, 0.9);
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-top: 25px;
            background-color: #4caf50;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button[type="submit"]:hover {
            background-color: #388e3c;
        }

        .cancelar {
            display: block;
            text-align: center;
            margin-top: 15px;
            padding: 10px;
            background-color: white;
            border: 1px solid #aaa;
            border-radius: 10px;
            color: #444;
            text-decoration: none;
            transition: border 0.3s ease;
        }
        .cancelar:hover {
            border-color: #000;
        }
    </style>

    <script>
        function toggleSelects() {
            var pacoteSelect = document.getElementById("pacoteSelect");
            var select2 = document.getElementById("select2"); // Quantidade por mês (Mensalista)
            var select3 = document.getElementById("select3"); // Quantidade de hora (Passaporte hora)
            var select4 = document.getElementById("select4"); // Quantidade por semana (Semanal)
            var select5 = document.getElementById("select5"); // Dia da Semana (Diária)

            // Desabilita todos por padrão
            select2.disabled = true;
            select3.disabled = true;
            select4.disabled = true;
            select5.disabled = true;

            // Habilita apenas o select correspondente
            if (pacoteSelect.value === "Mensalista") {
                select2.disabled = false;
            } else if (pacoteSelect.value === "semanal") {
                select4.disabled = false;
            } else if (pacoteSelect.value === "Passaporte hora") {
                select3.disabled = false;
            } else if (pacoteSelect.value === "Diária") {
                select5.disabled = false;
            }
            // Para "Hora avulsa", todos permanecem desabilitados
        }

        document.addEventListener("DOMContentLoaded", function() {
            var pacoteSelect = document.getElementById("pacoteSelect");
            pacoteSelect.addEventListener("change", toggleSelects);
            // Chama a função uma vez no carregamento da página para definir o estado inicial
            toggleSelects();
        });
    </script>
</head>
<body>
    
    <form action="<?php echo e(route('cliente.storePacotes')); ?>" method="POST">
        <div class="login-container">
            <h2>Adicionar Pacote para Cliente: <?php echo e($cliente->nome ?? $cliente->nome); ?></h2> 
            <div class="login-form">
                <?php echo csrf_field(); ?>
                
                <input type="hidden" name="cliente_id" value="<?php echo e($cliente->id); ?>">
                
                <select id="pacoteSelect" name="pacote" required>
                    <option value="">Escolha um plano</option>
                    <option value="Mensalista" <?php echo e(old('pacote', $cliente->pacote_selecionado ?? '') == 'Mensalista' ? 'selected' : ''); ?>>Mensalista</option>
                    <option value="semanal" <?php echo e(old('pacote', $cliente->pacote_selecionado ?? '') == 'semanal' ? 'selected' : ''); ?>>Semanal</option>
                    <option value="Diária" <?php echo e(old('pacote', $cliente->pacote_selecionado ?? '') == 'Diária' ? 'selected' : ''); ?>>Diária</option>
                    <option value="Passaporte hora" <?php echo e(old('pacote', $cliente->pacote_selecionado ?? '') == 'Passaporte hora' ? 'selected' : ''); ?>>Passaporte hora</option>
                    <option value="Hora avulsa" <?php echo e(old('pacote', $cliente->pacote_selecionado ?? '') == 'Hora avulsa' ? 'selected' : ''); ?>>Hora avulsa</option>
                </select>
                <?php $__errorArgs = ['pacote'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <select id="select2" name="quantidade_mes" <?php echo e(old('pacote') != 'Mensalista' ? 'disabled' : ''); ?>>
                    <option value="">Quantidade por mês</option>
                    <option value="4 horas" <?php echo e(old('quantidade_mes') == '4 horas' ? 'selected' : ''); ?>>4 horas</option>
                    <option value="6 horas" <?php echo e(old('quantidade_mes') == '6 horas' ? 'selected' : ''); ?>>6 horas</option>
                    <option value="8 horas" <?php echo e(old('quantidade_mes') == '8 horas' ? 'selected' : ''); ?>>8 horas</option>
                </select>
                <?php $__errorArgs = ['quantidade_mes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <select id="select3" name="quantidade_hora" <?php echo e(old('pacote') != 'Passaporte hora' ? 'disabled' : ''); ?>>
                    <option value="">Quantidade de hora</option>
                    <option value="10 horas" <?php echo e(old('quantidade_hora') == '10 horas' ? 'selected' : ''); ?>>10 horas</option>
                    <option value="20 horas" <?php echo e(old('quantidade_hora') == '20 horas' ? 'selected' : ''); ?>>20 horas</option>
                    <option value="30 horas" <?php echo e(old('quantidade_hora') == '30 horas' ? 'selected' : ''); ?>>30 horas</option>
                    <option value="50 horas" <?php echo e(old('quantidade_hora') == '50 horas' ? 'selected' : ''); ?>>50 horas</option>
                </select>
                <?php $__errorArgs = ['quantidade_hora'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <select id="select4" name="quantidade_semanal" <?php echo e(old('pacote') != 'semanal' ? 'disabled' : ''); ?>>
                    <option value="">Quantidade por semana</option>
                    <option value="2 vezes na semana 4 horas" <?php echo e(old('quantidade_semanal') == '2 vezes na semana 4 horas' ? 'selected' : ''); ?>>2 vezes na semana 4 horas</option>
                    <option value="3 vezes na semana 4 horas" <?php echo e(old('quantidade_semanal') == '3 vezes na semana 4 horas' ? 'selected' : ''); ?>>3 vezes na semana 4 horas</option>
                    <option value="2 vezes na semana 6 horas" <?php echo e(old('quantidade_semanal') == '2 vezes na semana 6 horas' ? 'selected' : ''); ?>>2 vezes na semana 6 horas</option>
                    <option value="3 vezes na semana 6 horas" <?php echo e(old('quantidade_semanal') == '3 vezes na semana 6 horas' ? 'selected' : ''); ?>>3 vezes na semana 6 horas</option>
                </select>
                <?php $__errorArgs = ['quantidade_semanal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <select id="select5" name="dia_semana" <?php echo e(old('pacote') != 'Diária' ? 'disabled' : ''); ?>>
                    <option value="">Dia da Semana</option>
                    <option value="Seg a Sex" <?php echo e(old('dia_semana') == 'Seg a Sex' ? 'selected' : ''); ?>>Seg a Sex</option>
                    <option value="Sáb" <?php echo e(old('dia_semana') == 'Sáb' ? 'selected' : ''); ?>>Sáb</option>
                    <option value="Dom e Feriados" <?php echo e(old('dia_semana') == 'Dom e Feriados' ? 'selected' : ''); ?>>Dom e Feriados</option>
                </select>
                <?php $__errorArgs = ['dia_semana'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                
                <label class="label-irmao">Possui irmão:
                    <select id="select6" name="possui_irmao">
                        <option value="0" <?php echo e(old('possui_irmao') == '0' ? 'selected' : ''); ?>>Não</option>
                        <option value="1" <?php echo e(old('possui_irmao') == '1' ? 'selected' : ''); ?>>1 irmão</option>
                        <option value="2" <?php echo e(old('possui_irmao') == '2' ? 'selected' : ''); ?>>2 irmãos</option>
                        
                    </select>
                </label>
                <?php $__errorArgs = ['possui_irmao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <button type="submit">Salvar Pacote 💾</button>
                <a class="cancelar" href="<?php echo e(route('cliente.index')); ?>">Cancelar</a>
            </div>
        </div>
    </form>
    
    <?php if($errors->any()): ?>
        <div class="alert-danger" style="margin-top: 20px;">
            <ul >
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
</body>
</html>
<?php /**PATH D:\laragon\www\Origens\resources\views/pacotes.blade.php ENDPATH**/ ?>