<?php

namespace Controllers;

use Models\Proyectos;
use Models\Tareas;

class TareasController
{

    public static function nuevaTarea($req, $res, $render): void
    {

        cors();
        auth();
        $user = $_SESSION["id"] ?? null;
        $proyecto_id = $req->body["proyecto"] ?? null;
        if (!$proyecto_id) {
            $res->status(401)->json(["msg" => "hubo un error", "type" => "error"]);
            exit;
        }

        $proyecto = Proyectos::findOne($proyecto_id);

        if ($proyecto) {
            if ($proyecto->creador === $user) {
                //agregamos la tarea

                $tarea = $req->body;

                $nuevaTarea = new Tareas($tarea);
                $alertas = $nuevaTarea->validate();

                if (!$alertas) {
                    $nuevaTarea->prepareToSave();
                    $nuevaTarea->save();
                    $res->json(["msg" => "Agregado correctamente", "type" => "exito"]);
                    exit;
                } else {
                    $res->status(501)->json(["msg" => $alertas, "type" => "error"]);
                    exit;
                }
            } else {
                //Restringido
                $res->status(401)->json(["msg" => "No permitido", "type" => "error"]);
                exit;
            }
        } else {
            $res->status(401)->json([
                "msg" => "No permitido",
                "type" => "error"
            ]);
            exit;
        }
    }

    public static function obtenerTarea($req, $res): void
    {
        cors();
        auth();
        $id = $req->params["id"];
        $tarea = Tareas::findOne($id);
        $id_proyecto = $tarea->proyecto;
        $proyecto = Proyectos::findOne($id_proyecto);

        if ($proyecto->creador === $_SESSION["id"]) {
            $res->json($tarea);
        } else {
            $res->status(401)->json("No Autorizado");
        }
    }

    public static function editarTarea($req, $res): void
    {
        cors();
        auth();

        $id = $req->body["id"];
        $tarea = Tareas::findOne($id);
        $tarea->sinc($req->body);
        $tarea->completa = 0;
        $tarea->completado_por = "";
        $resul = $tarea->save();

        if ($resul) {
            $res->json(["msg" => "Editada correctamente", "type" => "exito"]);
        } else {
            $res->status(501)->json(["msg" => "Hubo un error", "type" => "error"]);
        }
    }

    public static function eliminarTarea($req, $res): void
    {
        cors();
        auth();

        $id_tarea = $req->params["id"];
        $tarea = Tareas::findOne($id_tarea);
        $proyecto = Proyectos::findOne($tarea->proyecto);
        if ($proyecto->creador === $_SESSION["id"]) {
            $resul = $tarea->delete();
            $res->json($resul);
        } else {
            $res->status(401)->json("No AUTORIZADO");
        }
    }

    public static function cambiarEstado($req, $res): void
    {
        cors();
        auth();
        $id = $req->params["id"];
        $tarea = Tareas::findOne($id);

        $proyecto = Proyectos::findOne($tarea->proyecto);
        if ($proyecto->creador === $_SESSION["id"]) {
            if ($tarea->completa) {
                $tarea->completa = 0;
                $tarea->completado_por = "";
            } else {
                $tarea->completa = true;
                $tarea->completado_por = "Master";
            }
        } else {
            if ($tarea->completa) {
                $res->status(403)->json(["msg" => "Solo el creador del proyecto puede modificar su estado una vez completo"]);
                exit;
            } else {
                $tarea->completa = true;
                $tarea->completado_por = $_SESSION["email"];
            }
        }

        $resul = $tarea->save();
        $res->json($tarea);
        exit;
        if ($resul) {
            $res->json(["msg" => "Changed"]);
        } else {
            $res->status(401)->json("Restringido");
        }
    }
}
