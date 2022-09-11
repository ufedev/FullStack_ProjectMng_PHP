<div>
    <?php
    //show($proyecto);
    ?>
    <div class="header_proyecto">
        <div>
            <h2><?php echo ($proyecto->proyecto); ?></h2>
            <p><?php echo $proyecto->descripcion; ?></p>
        </div>
        <nav>
            <?php if ($proyecto->creador === $_SESSION["id"]) : ?>
                <a href="/editar-proyecto/<?php echo $proyecto->token; ?>">
                    <p>Editar</p>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>

                </a>
                <button class="delete" id="eliminar_proyecto">
                    <p> Eliminar </p>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </button>
                <button class="nuevo" id="nuevo_colaborador">
                    <p> Añadir Colaborador </p>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                    </svg>

                </button>

            <?php endif; ?>
        </nav>

    </div>

    <div class="tareas">
        <h1>Tareas</h1>
        <?php if ($proyecto->creador === $_SESSION["id"]) : ?>
            <button class="nueva_tarea" id="nueva_tarea">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                </svg>
                <p>Nueva Tarea</p>
            </button>
        <?php endif; ?>
        <?php foreach ($tareas as $tarea) : ?>

            <div class="tarea">

                <div>
                    <h3><?php echo $tarea->nombre; ?></h3>
                    <p><?php echo $tarea->descripcion; ?></p>
                    <p class="tarea_data"><span>Fecha de entrega:</span> <?php echo $tarea->entrega; ?></p>
                    <p class="tarea_data"><span>Prioridad:</span> <?php echo $tarea->prioridad; ?></p>
                    <?php if ($tarea->completado_por) : ?>
                        <p class="tarea_completadaPor"><span>Completada por:</span> <?php echo $tarea->completado_por; ?>
                        <p>
                        <?php endif; ?>
                </div>
                <nav>
                    <?php if ($proyecto->creador === $_SESSION["id"]) : ?>
                        <button class="editar" id="editar_tarea" data-tarea="<?php echo $tarea->id; ?>">Editar</button>
                    <?php endif; ?>
                    <button class="<?php if ($tarea->completa) {
                                        echo "tarea_completa";
                                    } ?>" id="completar_tarea" data-tarea="<?php echo $tarea->id; ?>">
                        <?php if ($tarea->completa) {
                            echo "Completa";
                        } else {
                            echo "Incompleta";
                        } ?>
                    </button>
                    <?php if ($proyecto->creador === $_SESSION["id"]) : ?>
                        <button class="eliminar" id="eliminar_tarea" data-tarea="<?php echo $tarea->id; ?>">Eliminar</button>
                    <?php endif; ?>
                </nav>
            </div>

        <?php endforeach; ?>
    </div>
    <?php if ($proyecto->creador === $_SESSION["id"]) : ?>
        <div class="colaboradores">
            <h1>Colaboradores</h1>
            <?php foreach ($colaboradores as $colaborador) : ?>
                <div class="colaborador">
                    <div>
                        <h3><?php echo $colaborador->email; ?></h3>

                    </div>
                    <nav>
                        <button class="eliminar" id="eliminar_colaborador" data-colaborador="<?php echo $colaborador->id; ?>">Eliminar</button>
                    </nav>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php include __DIR__ . "/../components/modalTarea.php"; ?>
    <?php include __DIR__ . "/../components/modalTareaEditar.php"; ?>
    <?php include_once __DIR__ . "/../components/modalColaborador.php"; ?>
</div>