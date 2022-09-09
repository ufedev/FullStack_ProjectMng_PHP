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
        $proyecto_id = $req->body["proyecto"];


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
                } else {
                    $res->status(501)->json(["msg" => $alertas, "type" => "error"]);
                }
            } else {
                //Restringido
                $res->status(401)->json(["msg" => "No permitido", "type" => "error"]);
            }
        } else {
            $res->status(401)->json([
                "msg" => "No permitido",
                "type" => "error"
            ]);
        }
    }
}
