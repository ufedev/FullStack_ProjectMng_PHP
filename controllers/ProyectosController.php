<?php

namespace Controllers;

use Ufe\RouterFS as Ro;

class ProyectosController
{
    public static function proyectos(Ro $router): void
    {
        auth();

        $content = DASHVIEW . "proyectos.php";

        $router->render($content, [
            "titulo" => "Proyectos"
        ], DASH);
    }
}
