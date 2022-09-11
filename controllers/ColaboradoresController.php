<?php

namespace Controllers;

use Models\Usuarios;
use Models\Colaboradores;
use Models\Proyectos;

class ColaboradoresController
{

    public static function buscarColaborador($req, $res): void
    {
        cors();
        auth();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = $req->body["email"] ?? null;
            $colaborador = Usuarios::findOneBy("email", $email);
            if ($colaborador) {
                $mostrar = [
                    "email" => $colaborador->email,
                    "nombre" => $colaborador->nombre,
                ];
                $res->json($mostrar);
            } else {
                $res->json("sin resultados...");
            }
        }
    }

    public static function eliminarColaborador($req, $res): void
    {
        cors();
        auth();;
        $col = Colaboradores::findOne($req->params["id"]);
        $proyecto_id = $col->proyecto;
        $proyecto = Proyectos::findOne($proyecto_id);
        if ($proyecto->creador === $_SESSION["id"]) {


            $resul = $col->delete();

            $res->json($resul);
        } else {
            $res->status(401)->json("ERROR");
        }
    }
}
