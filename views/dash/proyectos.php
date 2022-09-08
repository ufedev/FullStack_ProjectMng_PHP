<div>
    <h1>Proyectos</h1>


    <?php foreach ($proyectos as $proyecto) : ?>

        <div class="proyecto--for">

            <div class="proyecto_body">
                <p class="proyecto_nombre"><?php echo $proyecto->proyecto; ?></p>
                <p class="proyecto_descripcion"><?php echo $proyecto->descripcion; ?></p>
                <p class="proyecto_fecha">Fecha de entrega <?php echo $proyecto->entrega; ?></p>
            </div>
            <div class="proyecto_menu">
                <?php if ($proyecto->creador !== $_SESSION["id"]) : ?>
                    <p class="proyecto_colaborador">Colaborador</p>

                <?php endif; ?>
                <a href="/proyectos/<?php echo $proyecto->token ?? ""; ?>">ver Proyecto</a>
            </div>

        </div>

    <?php endforeach; ?>
</div>