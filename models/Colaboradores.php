<?php


namespace Models;


class Colaboradores extends Main
{

    public static string $table = "colaboradores";

    public $proyecto;
    public $colaborador;


    public function __construct($args = [])
    {
        $this->proyecto = $args["proyecto"] ?? "";
        $this->colaborador = $args["colaborador"] ?? '';
    }

    public static function colaboradores($proyecto_id): ?array
    {
        $col = static::$table;
        $user = "usuarios";

        $qry = "SELECT $user.email as email, $col.id as id FROM $col";
        $qry .= " LEFT JOIN $user ON $user.id=$col.colaborador";
        $qry .= " WHERE $col.proyecto = $proyecto_id";
        $r = static::query($qry);
        $data = [];
        while ($result = $r->fetch_assoc()) {
            $data[] = (object)$result;
        }

        return $data;
    }
}
