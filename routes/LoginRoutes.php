<?php

use Controllers\Pages;


//Log
$router->get("/", [Pages::class, "login"]);
$router->post("/", [Pages::class, "login"]);
$router->get("/logout", [Pages::class, "logout"]);
// Crear Cuenta
$router->get("/registrar", [Pages::class, "registrar"]);
$router->post("/registrar", [Pages::class, "registrar"]);
$router->get("/registro-exitoso", [Pages::class, "registroExitoso"]);
//confirmar
$router->get("/confirmar/:token", [Pages::class, "confirmar"]);
//olivide password
$router->get("/olvide", [Pages::class, "olvide"]);
$router->post("/olvide", [Pages::class, "olvide"]);
//restablecer password
$router->get("/restablecer/:token", [Pages::class, "restablecer"]);
$router->post("/restablecer/:token", [Pages::class, "restablecer"]);
