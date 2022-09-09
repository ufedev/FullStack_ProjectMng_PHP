<?php

namespace Controllers;

use Models\Proyectos;

class ProyectosController
{
    public static function proyectos($req, $res, $render): void
    {
        auth();


        $proyectos = Proyectos::proyectos($_SESSION['id']);



        $content = DASHVIEW . "proyectos.php";

        $render($content, [
            "titulo" => "Proyectos",
            "proyectos" => $proyectos
        ], DASH);
    }
    public static function verProyecto($req, $res, $render): void
    {
        auth();
        $proyecto = null;
        $token = $req->params['token'];
        $data = Proyectos::proyecto($_SESSION['id'], $token);
        $proyecto = $data["proyecto"];
        $tareas = $data["tareas"];
        $render(DASHVIEW . "proyecto.php", [
            "titulo" => "Proyecto",
            "proyecto" => $proyecto,
            "tareas" => $tareas ?? []
        ], DASH);
    }
    public static function nuevoProyecto($req, $res, $render): void
    {
        auth();
        $alertas = null;
        $clase = null;
        $nuevoProyecto = new Proyectos();
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $nuevoProyecto = new Proyectos($req->body);
            $alertas = $nuevoProyecto->validate();

            if (!$alertas) {
                $nuevoProyecto->prepareToSave();
                $result = $nuevoProyecto->save();
                if ($result) {
                    $alertas = "Nuevo proyecto agregado";
                    $clase = "exito";
                }
            }
        }

        $render(DASHVIEW . "nuevoProyecto.php", [
            "titulo" => "New Project",
            "alertas" => $alertas,
            "clase" => $clase
        ], DASH);
    }
}
