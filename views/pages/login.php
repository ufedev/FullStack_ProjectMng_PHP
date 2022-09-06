<div class="login_pages">
    <h1>Inicia Sesión y Administra tus <span>Proyectos</span></h1>

    <div>
        <form method="POST">
            <div>
                <label for="email">Email</label>
                <input type="text" name="email" id="email" placeholder="su Email">
            </div>
            <div>
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" placeholder="su Contraseña">
            </div>
            <input type="submit" value="Iniciar Sesión">
        </form>
        <div>
            <a href="/registrar">Registrarse</a><a href="/olvide">Olvide mi contraseña</a>
        </div>
    </div>

    <?php
    include __DIR__ . "/../../components/alertas.php";
    ?>
</div>