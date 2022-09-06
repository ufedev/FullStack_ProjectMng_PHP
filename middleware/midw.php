<?php
session_start();
// se agrega al principio de cada controller para bloquear la entrada si las condiciones no se cumplen
function auth(): void
{
    if (empty($_SESSION)) {
        header("location:/");
    }
    foreach ($_SESSION as $key => $value) {

        if (!isset($_SESSION[$key]) || is_null($_SESSION[$key])) {
            header("location:/");
        }
        if ($key === "login") {
            if (!$value) {
                header("location:/");
            }
        }
    }
}
function no_auth(): void
{
    if (!empty($_SESSION)) {
        header("location: /proyectos");
    }
    foreach ($_SESSION as $key => $value) {

        if (isset($_SESSION[$key]) || !is_null($_SESSION[$key])) {
            header("location:/proyectos");
        }
    }
}
