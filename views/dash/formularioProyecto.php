<div>
    <h1>Nuevo Proyecto</h1>
    <div class="dashboard_form">
        <form method="POST">
            <div>
                <label for="nombre">Nombre del Proyecto</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre del Proyecto" value="<?php echo $proyecto->nombre; ?>">
            </div>
            <div>
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" placeholder="Descripcion del Proyecto"><?php echo $proyecto->descripcion; ?></textarea>
            </div>
            <div>
                <label for="cliente">Nombre del Cliente</label>
                <input type="text" name="cliente" id="cliente" placeholder="Nombre del Cliente" value="<?php echo $proyecto->cliente; ?>">
            </div>
            <div>
                <label for="fecha">Fecha de entrega</label>
                <input type="date" name="fecha" id="fecha" value="<?php echo $proyecto->entrega; ?>">
            </div>
            <input type="submit" value="Agregar">
        </form>
    </div>
    <?php
    include __DIR__ . "/../components/alertas.php";
    ?>
</div>