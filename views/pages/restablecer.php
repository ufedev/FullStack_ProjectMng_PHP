<div class="login_pages">
    <h1>Cambia tu password y no pierdas tus <span>Proyectos</span></h1>

    <div>
        <?php if (!$alertas) : ?>
            <form method="POST">
                <div>
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" placeholder="Nueva contraseña">
                </div>
                <div>
                    <label for="password2">Repita la Contraseña</label>
                    <input type="password" name="password2" id="password2" placeholder="Repita la nueva contraseña">
                </div>

                <input type="submit" value="Cambiar">
            </form>
        <?php endif; ?>
        <div></div>
    </div>
    <?php
    include __DIR__ . "/../../components/alertas.php";
    ?>
</div>