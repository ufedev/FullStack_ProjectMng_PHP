<?php


namespace Models;

class Tareas extends Main
{
    public static string $table = 'tareas';
    public $nombre;
    public $descripcion;
    public $entrega;
    public $prioridad;
    public $proyecto;
    public $completa;
}
