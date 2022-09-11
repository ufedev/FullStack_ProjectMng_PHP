<?php

use Controllers\ProyectosController;
use Controllers\TareasController;
use Controllers\ColaboradoresController;

$router->get("/proyectos", [ProyectosController::class, "proyectos"]);
$router->get("/proyectos/:token", [ProyectosController::class, "verProyecto"]);

$router->put("/proyectos/:token", [ProyectosController::class, "agregarColaborador"]); // solo para agregar colaborador

$router->delete("/proyectos/:token", [ProyectosController::class, "eliminarProyecto"]);
$router->get("/obtener-proyectos", [ProyectosController::class, "obtenerProyectos"]);

//Colaboradores
$router->post("/colaboradores", [ColaboradoresController::class, "buscarColaborador"]);
$router->delete("/colaboradores/:id", [ColaboradoresController::class, "eliminarColaborador"]);
//Agregar Proyecto
$router->get("/nuevo-proyecto", [ProyectosController::class, "nuevoProyecto"]);
$router->post("/nuevo-proyecto", [ProyectosController::class, "nuevoProyecto"]);
$router->get("/editar-proyecto/:token", [ProyectosController::class, "editarProyecto"]);
$router->post("/editar-proyecto/:token", [ProyectosController::class, "editarProyecto"]);
//Tareas API
$router->get("/tareas/:id", [TareasController::class, "obtenerTarea"]);
$router->delete("/tareas/:id", [TareasController::class, "eliminarTarea"]);
$router->post("/tareas", [TareasController::class, "nuevaTarea"]);
$router->put("/tareas", [TareasController::class, "editarTarea"]);
$router->put("/tareas/:id", [TareasController::class, "cambiarEstado"]);
