<div class="login_pages">
    <h1>Recupera tu cuenta y no pierdas tus <span>Proyectos</span></h1>

    <div>
        <form method="POST">
            <div>
                <label for="email">Email</label>
                <input type="text" name="email" id="email" placeholder="su Email">
            </div>

            <input type="submit" value="Recuperar">
        </form>
        <div>
            <a href="/">Iniciar Sesión</a><a href="/registrar">Registraté</a>
        </div>
    </div>

    <?php

    include __DIR__ . "/../components/alertas.php";

    ?>
</div>