<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Registro de Presença</title>
    <style>
        /* Reset básico e box-sizing para um layout previsível */
        *, *::before, *::after {
            box-sizing: border-box;
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
            justify-content: center; /* Centraliza horizontalmente o conteúdo */
            align-items: center; /* Centraliza verticalmente o conteúdo */
            padding: 20px; /* Adiciona um padding nas bordas em telas pequenas */
        }

        /* Container principal que envolve todo o conteúdo do calendário e formulários */
        .main-content-wrapper {
            background-color: rgba(255, 255, 255, 0.4); /* Fundo translúcido */
            backdrop-filter: blur(8px); /* Efeito de desfoque */
            max-width: 1200px; /* Largura máxima para o conteúdo */
            width: 100%; /* Ocupa a largura total disponível */
            margin: auto; /* Centraliza o wrapper */
            padding: 30px;
            border-radius: 16px; /* Cantos arredondados */
            box-shadow: 0 4px 12px rgba(0,0,0,0.3); /* Sombra suave */
            display: flex; /* Transforma este container em flex para alinhar calendário e presenca-container */
            flex-wrap: wrap; /* Permite que os blocos quebrem para a próxima linha */
            gap: 30px; /* Espaço entre o calendário e a área de presença */
            justify-content: center; /* Centraliza os itens flex quando houver espaço */
            align-items: flex-start; /* <--- MUDANÇA CRUCIAL: Alinha os itens flex ao início (topo) para evitar que se estiquem */
        }

        /* Estilos para mensagens de sucesso e erro */
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 8px;
            text-align: center;
            width: 100%; /* Garante que ocupe a largura total */
            flex-basis: 100%; /* Ocupa a linha inteira em flexbox */
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 8px;
            text-align: left;
            width: 100%; /* Garante que ocupe a largura total */
            flex-basis: 100%; /* Ocupa a linha inteira em flexbox */
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
            margin-bottom: 10px;
            text-align: left;
            display: block;
        }

        /* --- Calendário --- */
        .calendar-container {
            flex: 1; /* Permite que o calendário cresça */
            min-width: 300px; /* Largura mínima para o calendário */
            max-width: 450px; /* Largura máxima para manter o layout equilibrado */
            background-color: rgba(255, 255, 255, 0.7);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            /* REMOVIDO: qualquer altura fixa ou min-height que estivesse causando o espaço extra */
        }

        .calendar .month {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        .calendar .month i {
            cursor: pointer;
            font-size: 1.2em;
            color: #4caf50;
            transition: color 0.2s ease;
        }
        .calendar .month i:hover {
            color: #388e3c;
        }

        .calendar .weekdays, .calendar .days {
            display: flex;
            flex-wrap: wrap;
            text-align: center;
        }

        .calendar .weekdays div, .calendar .days div {
            width: calc(100% / 7);
            padding: 10px 0; /* Padding vertical para os dias */
        }

        .calendar .weekdays div {
            font-weight: bold;
            color: #555;
            border-bottom: 1px solid #eee;
            margin-bottom: 5px;
        }

        .calendar .days div {
            cursor: pointer;
            border-radius: 50%;
            transition: background-color 0.2s ease;
            position: relative; /* Para a bolinha de presença */
        }

        .calendar .days div:hover:not(.today):not(.selected):not(.prev-date) {
            background-color: #e0e0e0;
        }

        .calendar .days .today {
            background-color: #4caf50;
            color: white;
            font-weight: bold;
        }

        .calendar .days .selected {
            background-color: #388e3c;
            color: white;
            font-weight: bold;
        }

        .calendar .days .prev-date {
            color: #aaa;
            cursor: default;
            background-color: transparent;
        }
        .calendar .days .prev-date:hover {
            background-color: transparent;
        }
        /* Indicador de presença para o dia */
        .calendar .days .has-presenca::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
            width: 6px;
            height: 6px;
            background-color: #ff9800; /* Cor da bolinha de presença */
            border-radius: 50%;
        }


        /* --- Área de Registro de Presença --- */
        .presence-container {
            flex: 1; /* Permite que este container cresça */
            min-width: 300px; /* Largura mínima para os formulários */
            background-color: rgba(255, 255, 255, 0.7);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column; /* Organiza o conteúdo verticalmente */
            justify-content: flex-start; /* Alinha o conteúdo ao topo */
        }

        .presence-container h4 {
            font-size: 1.2em;
            color: #333;
            margin-top: 20px;
            margin-bottom: 15px;
            text-align: center;
        }
        .presence-container h4:first-of-type {
            margin-top: 0; /* Remove margem superior do primeiro h4 */
        }

        .presence-container form {
            margin-bottom: 25px; /* Espaço entre os formulários */
        }

        .presence-container form select,
        .presence-container form input[type="datetime-local"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1em;
            background-color: rgba(255, 255, 255, 0.9);
        }

        .presence-container form button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background-color: #4CAF50; /* Cor verde */
            color: white;
            font-size: 1.1em;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .presence-container form button:hover {
            background-color: #388e3c; /* Verde mais escuro */
        }

        .inicio {
            display: block;
            text-align: center;
            margin-bottom: 25px;
            padding: 10px;
            background-color: #007bff; /* Azul */
            color: white;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            font-weight: bold;
        }
        .inicio:hover {
            background-color: #0056b3; /* Azul mais escuro */
        }

        /* Lista de Presenças */
        .presence-list {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 15px;
            border-radius: 10px;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
            min-height: 100px; /* Garante uma altura mínima */
            overflow-y: auto; /* Adiciona scroll se a lista for muito longa */
            max-height: 250px; /* Limita a altura da lista */
        }
        .presence-list ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .presence-list li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
            color: #444;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .presence-list li:last-child {
            border-bottom: none;
        }
        .presence-list p { /* Para o 'Nenhuma presença registrada' */
            text-align: center;
            color: #777;
            margin: 20px 0;
        }

        /* Media Queries para Responsividade */
        @media (max-width: 768px) {
            .main-content-wrapper {
                flex-direction: column; /* Empilha os blocos verticalmente */
                padding: 20px;
                gap: 20px; /* Reduz o gap entre os blocos empilhados */
                align-items: center; /* Centraliza os itens quando empilhados */
            }
            .calendar-container, .presence-container {
                max-width: 100%; /* Ocupa a largura total em telas pequenas */
                min-width: unset; /* Remove o min-width para telas pequenas */
            }
        }
    </style>
</head>
<body>

    <div class="main-content-wrapper"> 

        
        <?php if(session('success')): ?>
            <div class="alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        
        <?php if($errors->any()): ?>
            <div class="alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        
        <?php $__errorArgs = ['general_error'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="alert-danger"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <div class="calendar-container">
            <div class="calendar">
                <div class="month">
                    <i class="fas fa-angle-left prev"></i>
                    <div class="date">maio 2024</div> 
                    <i class="fas fa-angle-right next"></i>
                </div>
                <div class="weekdays">
                    <div>Dom</div>
                    <div>Seg</div>
                    <div>Ter</div>
                    <div>Qua</div>
                    <div>Qui</div>
                    <div>Sex</div>
                    <div>Sáb</div>
                </div>
                <div class="days"></div>
            </div>
        </div>

        <div class="presence-container">
            <div class="add-presence">
                <a href="<?php echo e(route('cliente.index')); ?>" class="inicio">Página Inicial</a>
                
                <h4>Registrar Entrada 🚀</h4>
                <form action="<?php echo e(route('presenca.entrada')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <select name="cliente_id" required>
                        <option value="">Selecione uma criança</option>
                        <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cliente->id); ?>" <?php echo e(old('cliente_id') == $cliente->id ? 'selected' : ''); ?>>
                                <?php echo e($cliente->nome_crianca); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <input type="datetime-local" name="entrada" required value="<?php echo e(old('entrada')); ?>">
                    <?php $__errorArgs = ['entrada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <button type="submit">Registrar Entrada</button>
                </form>

                <h4>Registrar Saída 👋</h4>
                <form action="<?php echo e(route('presenca.saida')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <select name="cliente_id" required>
                        <option value="">Selecione uma criança</option>
                        <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cliente->id); ?>" <?php echo e(old('cliente_id') == $cliente->id ? 'selected' : ''); ?>>
                                <?php echo e($cliente->nome_crianca); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <input type="datetime-local" name="saida" required value="<?php echo e(old('saida')); ?>">
                    <?php $__errorArgs = ['saida'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <button type="submit">Registrar Saída</button>
                </form>

                <h4>Lista de Presenças do Dia 📝</h4>
                <div class="presence-list">
                    <ul>
                        
                        <?php if($presencas->isEmpty()): ?>
                            <p>Nenhuma presença registrada para este dia.🙁</p>
                        <?php else: ?>
                            <?php $__currentLoopData = $presencas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $presenca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <?php echo e($presenca->cliente->nome_crianca); ?> | Entrada: <?php echo e(\Carbon\Carbon::parse($presenca->entrada)->format('H:i')); ?> | Saída: <?php echo e(\Carbon\Carbon::parse($presenca->saida ?? '')->format('H:i')); ?>

                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const daysEl = document.querySelector('.days');
            const dateEl = document.querySelector('.date');
            const prevEl = document.querySelector('.prev');
            const nextEl = document.querySelector('.next');
            const presencaListEl = document.querySelector('.presence-list ul');

            let selectedDate = new Date(); // Inicia com a data atual

            // Função para renderizar o calendário
            const renderCalendar = () => {
                const month = selectedDate.getMonth();
                const year = selectedDate.getFullYear();

                // Atualiza o nome do mês e ano
                dateEl.textContent = `${selectedDate.toLocaleString('pt-BR', { month: 'long' })} ${year}`;

                const firstDayOfMonth = new Date(year, month, 1).getDay(); // Dia da semana do 1º dia do mês (0=domingo)
                const lastDateOfMonth = new Date(year, month + 1, 0).getDate(); // Último dia do mês

                let daysHtml = '';

                // Preenche os dias do mês anterior
                const lastDayOfPrevMonth = new Date(year, month, 0).getDate();
                for (let x = firstDayOfMonth; x > 0; x--) {
                    daysHtml += `<div class="prev-date">${lastDayOfPrevMonth - x + 1}</div>`;
                }

                // Preenche os dias do mês atual
                for (let i = 1; i <= lastDateOfMonth; i++) {
                    const currentDate = new Date(year, month, i);
                    const isToday = currentDate.toDateString() === new Date().toDateString();
                    const isSelected = currentDate.toDateString() === selectedDate.toDateString(); // Mantém o dia selecionado visualmente
                    let className = '';
                    if (isSelected) className += 'selected ';
                    if (isToday) className += 'today ';
                    
                    // Adicione uma classe para dias com presença se tivermos essa informação (via API, futuramente)
                    // Por enquanto, apenas um placeholder para um dia com presença
                    // if (i === 10) className += 'has-presenca'; // Exemplo: dia 10 sempre terá presença visualmente

                    daysHtml += `<div class="day ${className.trim()}" data-date="${currentDate.toISOString().split('T')[0]}">${i}</div>`;
                }

                daysEl.innerHTML = daysHtml;

                // Adiciona listeners para clique nos dias
                document.querySelectorAll('.days .day').forEach(day => {
                    day.addEventListener('click', (e) => {
                        document.querySelectorAll('.days .day').forEach(d => d.classList.remove('selected'));
                        e.target.classList.add('selected');
                        selectedDate = new Date(e.target.getAttribute('data-date'));
                        loadPresencas(selectedDate.toISOString().split('T')[0]);
                    });
                });
            };

            // Função para carregar presenças via Fetch API
            const loadPresencas = (dateString) => {
                // Remove qualquer mensagem de erro de fetch anterior
                const existingFetchError = document.querySelector('.fetch-error-display');
                if (existingFetchError) {
                    existingFetchError.remove();
                }

                fetch(`/presenca/api/${dateString}`)
                    .then(response => {
                        if (!response.ok) {
                            // Se a resposta não for OK (ex: 404, 500), lança um erro
                            throw new Error(`Erro ${response.status} ao carregar presenças: ${response.statusText}`);
                        }
                        return response.json();
                    })
                    .then(presencas => {
                        presencaListEl.innerHTML = ''; // Limpa a lista atual

                        if (presencas.length === 0) {
                            presencaListEl.innerHTML = '<p>Nenhuma presença registrada para esta data. 🙁</p>';
                        } else {
                            presencas.forEach(presenca => {
                                const li = document.createElement('li');
                                // Formata entrada e saída para exibição
                                const entrada = presenca.entrada ? new Date(presenca.entrada).toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' }) : 'N/A';
                                const saida = presenca.saida ? new Date(presenca.saida).toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' }) : 'Ainda no local';
                                
                                li.innerHTML = `
                                    <span>${presenca.cliente_nome_crianca}</span>
                                    <span>Entrada: ${entrada} | Saída: ${saida}</span>
                                `;
                                presencaListEl.appendChild(li);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Erro no fetch de presenças:', error);
                        // Exibe a mensagem de erro de fetch no container de presença
                        const newErrorDisplay = document.createElement('div');
                        newErrorDisplay.classList.add('fetch-error-display', 'alert-danger');
                        newErrorDisplay.textContent = `Erro ao carregar presenças. Detalhe: ${error.message}`;
                        document.querySelector('.presence-container').prepend(newErrorDisplay);
                    });
            };

            // Listeners para os botões de navegação do mês
            prevEl.addEventListener('click', () => {
                selectedDate.setMonth(selectedDate.getMonth() - 1);
                renderCalendar();
                loadPresencas(selectedDate.toISOString().split('T')[0]);
            });

            nextEl.addEventListener('click', () => {
                selectedDate.setMonth(selectedDate.getMonth() + 1);
                renderCalendar();
                loadPresencas(selectedDate.toISOString().split('T')[0]);
            });

            // Inicializa o calendário e carrega as presenças para a data atual no carregamento da página
            renderCalendar();
            loadPresencas(selectedDate.toISOString().split('T')[0]);
        });
    </script>
</body>
</html>
<?php /**PATH D:\laragon\www\Origens\resources\views/presenca.blade.php ENDPATH**/ ?>