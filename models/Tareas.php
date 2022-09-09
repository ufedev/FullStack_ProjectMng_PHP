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



    public function __construct($args = [])
    {
        $this->nombre = $args['nombre'] ?? "";
        $this->descripcion = $args['descripcion'] ?? "";
        $this->entrega = $args['entrega'] ?? "";
        $this->prioridad = $args['prioridad'] ?? "";
        $this->completa = 0;
        $this->proyecto = $args['proyecto'] ?? "";
    }

    public function validate(): ?string
    {
        static::$alertas = "";

        if (in_array("", [$this->nombre, $this->descripcion, $this->entrega, $this->prioridad])) {
            static::$alertas = "Faltan Datos";
        }

        return null;
    }
}
