<?php

use Controllers\ProyectosController;
use Controllers\TareasController;

$router->get("/proyectos", [ProyectosController::class, "proyectos"]);
$router->get("/proyectos/:token", [ProyectosController::class, "verProyecto"]);
//Agregar Proyecto
$router->get("/nuevo-proyecto", [ProyectosController::class, "nuevoProyecto"]);
$router->post("/nuevo-proyecto", [ProyectosController::class, "nuevoProyecto"]);
//Tareas API
$router->post("/tareas", [TareasController::class, "nuevaTarea"]);
