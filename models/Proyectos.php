<?php


namespace Models;

use Models\Tareas;


class Proyectos extends Main
{

    public static string $table = "proyectos";

    public $nombre;
    public $descripcion;
    public $cliente;
    public $entrega;
    public $creador;
    public $token;

    public function __construct($args = [])
    {
        $this->nombre = $args['nombre'] ?? "";
        $this->descripcion = $args['descripcion'] ?? "";
        $this->cliente = $args['cliente'] ?? "";
        $this->entrega = $args['fecha'] ?? "";
        $this->creador = $_SESSION['id'] ?? "";
        $this->token = md5(uniqid(rand(), true));
    }

    public function validate(): ?string
    {

        if (in_array("", [$this->nombre, $this->descripcion, $this->cliente, $this->entrega])) {
            return static::$alertas = "Todos los Campos son obligatorios";
        }

        return null;
    }

    public static function proyectos($id_user)
    {
        // Obtiene los proyectos tanto de creador como colaborador. si trae mas de un mismo proyecto significa que tiene muchos colaboradores para eso se agrupa por id de proyecto y trae solo un registro
        $return = [];
        $tabla = static::$table;
        $secTabla = "colaboradores";
        $qry = "SELECT $tabla.token as token, $tabla.id as id,$tabla.entrega as entrega, $tabla.nombre as proyecto, $tabla.descripcion as descripcion, $tabla.creador as creador, $secTabla.colaborador as colaborador, $secTabla.proyecto as proyectoID FROM $tabla";
        $qry .= " LEFT JOIN $secTabla ON $secTabla.proyecto = $tabla.id";
        $qry .= " WHERE creador=$id_user OR colaborador=$id_user";
        $qry .= " GROUP BY $tabla.id";

        $res = static::query($qry);

        while ($r = $res->fetch_assoc()) {
            $val = (object)$r;
            $return[] = $val;
        }

        return $return;
    }
    public static function proyecto($id_user, $token): ?array
    {

        $data = [];
        $proyecto = null;
        $tareas = [];
        $t_proyecto = static::$table;
        $t_tareas = "tareas";
        $t_col = "colaboradores";
        $qry = "SELECT $t_proyecto.token as token, $t_proyecto.id as id,$t_proyecto.entrega as entrega, $t_proyecto.nombre as proyecto, $t_proyecto.descripcion as descripcion, $t_proyecto.creador as creador,";
        $qry .= " $t_col.colaborador as colaborador, $t_col.proyecto as proyectoID FROM $t_proyecto";
        $qry .= " LEFT JOIN $t_col ON $t_col.proyecto = $t_proyecto.id";
        $qry .= " WHERE token='$token' AND creador=$id_user OR  token='$token' AND colaborador=$id_user ";
        $qry .= " GROUP BY $t_proyecto.id";
        $res = static::query($qry);
        while ($r = $res->fetch_assoc()) {
            $proyecto = (object)$r;
        }

        if (!$proyecto) {
            header("location:/");
        } else {
            $tareas = Tareas::findBy("proyecto", $proyecto->id);

            $data['proyecto'] = $proyecto;
            $data['tareas'] = $tareas;
        }
        return $data;
    }
}
