<div class="login_pages">
    <h1>Registrate y comienza a Administrar tus <span>Proyectos</span></h1>

    <div>
        <form method="POST">
            <div>
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" placeholder="Su nombre" id="nombre" value="<?php echo $registro->nombre; ?>">
            </div>
            <div>
                <label for="email">Email</label>
                <input type="text" name="email" placeholder="Su Email" id="email" value="<?php echo $registro->email; ?>">
            </div>
            <div>
                <label for="password">Contraseña</label>
                <input type="password" name="password" placeholder="Elija una Contraseña" id="password">
            </div>
            <div>
                <label for="password2">Repetir Contraseña</label>
                <input type="password" name="password2" placeholder="Repita la contraseña" id="password2">
            </div>
            <input type="submit" value="Crear Cuenta">
        </form>
        <div>
            <a href="/">Iniciar Sesión</a><a href="/olvide">Olvide mi contraseña</a>
        </div>
    </div>

    <?php
    include __DIR__ . "/../../components/alertas.php";

    ?>
</div>