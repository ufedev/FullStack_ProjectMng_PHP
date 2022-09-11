<?php

namespace Controllers;

use Models\Proyectos;
use Models\Colaboradores;
use Models\Usuarios;

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
        $colaboradores = Colaboradores::colaboradores($proyecto->id);
        $render(DASHVIEW . "proyecto.php", [
            "titulo" => "Proyecto",
            "proyecto" => $proyecto,
            "tareas" => $tareas ?? [],
            "colaboradores" => $colaboradores ?? []
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
                    header("refresh:2;url=/");
                }
            }
        }

        $render(DASHVIEW . "formularioProyecto.php", [
            "titulo" => "New Project",
            "alertas" => $alertas,
            "clase" => $clase,
            "proyecto" => $nuevoProyecto
        ], DASH);
    }

    public static function editarProyecto($req, $res, $render): void
    {
        auth();
        $token_proyecto = $req->params["token"] ?? null;
        $alertas = null;
        $clase = null;
        $editarProyecto = Proyectos::findOneBy("token", $token_proyecto);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $editarProyecto->sinc($req->body);
            $alertas = $editarProyecto->validate();

            if (!$alertas) {
                $resul = $editarProyecto->save();

                if ($resul) {
                    $alertas = "Proyecto Editado!";
                    $clase = "exito";
                    header("refresh:3;url=/proyectos/" . $editarProyecto->token);
                }
            }
        }


        $render(DASHVIEW . "formularioProyecto.php", [
            "titulo" => "Editar Proyecto",
            "clase" => $clase,
            "proyecto" => $editarProyecto,
            "alertas" => $alertas
        ], DASH);
    }
    //API
    public static function eliminarProyecto($req, $res): void
    {
        cors();
        auth();
        $token = $req->params["token"];
        $proyecto = Proyectos::findOneBy("token", $token);


        if ($proyecto->creador === $_SESSION["id"]) {
            $resul = $proyecto->delete();
            if ($resul) {

                $res->json("Deleted");
            }
        }
    }

    public static function obtenerProyectos($req, $res): void
    {
        cors();
        auth();


        $proyectos = Proyectos::dataListProyectos($_SESSION["id"]);

        $res->json($proyectos);
    }

    public static function agregarColaborador($req, $res): void
    {

        cors();
        auth();


        $token = $req->params["token"] ?? null;
        $colaborador_email = $req->body["email"] ?? null;

        if ($token && $colaborador_email) {
            if ($colaborador_email === $_SESSION["email"]) {
                $res->json("Eres el master del Proyecto");
                exit;
            }
            $proyecto = Proyectos::findOneBy("token", $token);
            $colaborador = Usuarios::findOneBy("email", $colaborador_email);
            $existeCol = Colaboradores::findOneBy("colaborador", $colaborador->id);
            if ($existeCol) {
                $res->json("Ya se encuentra como colaborador");
                exit;
            }
            if ($proyecto->creador === $_SESSION["id"]) {
                $nuevoCol = new Colaboradores();
                $nuevoCol->proyecto = $proyecto->id;
                $nuevoCol->colaborador = $colaborador->id;
                $nuevoCol->prepareToSave();
                $result = $nuevoCol->save();
                if ($result) {
                    $res->json("Agregado...");
                }
            }
        } else {
            $res->json("ERROR");
        }
    }
}
