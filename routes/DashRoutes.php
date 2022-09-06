<?php

use Controllers\ProyectosController;

$router->get("/proyectos", [ProyectosController::class, "proyectos"]);
