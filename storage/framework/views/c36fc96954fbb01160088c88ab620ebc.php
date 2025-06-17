<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    
    <link rel="stylesheet" href="<?php echo e(asset('css/index.css')); ?>">
</head>
<body>
<body>
    <div class="conteiner">
        <h2>Clientes:</h2>
        <div class="top-bar">
            <div class="left-actions">
                <form action="<?php echo e(route('cliente.create')); ?>" method="GET">
                    <input class="novo_cliente" type="submit" value=" + Incluir">
                </form>
                <a href="<?php echo e(route('presenca.index')); ?>" class="presenca">Presença</a>
            </div>
            <div class="right-actions">
                <form class="pesquisar" action="<?php echo e(route('cliente.index')); ?>" method="GET">
                    <input type="text" name="search" placeholder="Pesquisar..." value="<?php echo e($search ?? ''); ?>">
                    <button type="submit">Pesquisar</button>
                </form>
            </div>
        </div>

        
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        
        <?php $__empty_1 = true; $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
            <li>
                <a class="nomes"><?php echo e($cliente->nome_crianca); ?></a>
                
                <div class="actions-group">
                    <a href="<?php echo e(route('cliente.show', ['id' => $cliente->id])); ?>" class="detalhes-btn">Detalhes</a>
                    
                    <form action="<?php echo e(route('cliente.edit', $cliente->id)); ?>" method="GET">
                        <input class="edit" type="submit" value="Editar">
                    </form>
                    
                    <form action="<?php echo e(route('cliente.destroy', $cliente->id)); ?>" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <input class="apagar" type="submit" value="Apagar">
                    </form>
                </div>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            
            <?php if(isset($search) && !empty($search)): ?>
                <p>Nenhum cliente encontrado para a pesquisa "<?php echo e($search); ?>".</p>
            <?php else: ?>
                <p>Nenhum cliente cadastrado. Comece adicionando um! 📝</p>
            <?php endif; ?>
        <?php endif; ?>

        
        <?php echo e($clientes->links()); ?>

    </div>
</body>
</html>

<?php /**PATH D:\laragon\www\Origens\resources\views/index.blade.php ENDPATH**/ ?>