<?php

namespace Models;

class Usuarios extends Main
{

    public $id;
    public $nombre;
    public $password;
    public $email;
    public $confirmado;
    public $token;
    public $createAt;
    public $updateAt;

    public static string $table = "usuarios";
    public static string $alertas = "";

    public function __construct($args = [])
    {
        $this->nombre = $args['nombre'] ?? "";
        $this->password = $args['password'] ?? "";
        $this->email = $args['email'] ?? "";
        $this->confirmado =  0;
    }
    public function validate($password2): ?string
    {
        $exist = $this->findBy("email", $this->email);

        if ($exist) {
            return static::$alertas = "El Email ya esta en uso";
        }

        if (in_array("", [$this->nombre, $this->email, $this->password])) {
            return static::$alertas = "Todos los Campos son obligatorios";
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return static::$alertas = "Email no válido";
        }
        if ($this->password != $password2) {
            return static::$alertas = "Las contraseñas no coinciden";
        }
        if (strlen($this->password) <= 6) {
            return static::$alertas = "La contraseña debe contener al menos 7 caracteres";
        }
        return null;
    }
    public function prepareToSave(): void
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        $this->token = md5(uniqid(rand(), true));
        $this->createAt = date('Y-m-d H:i:s');
        $this->updateAt = date('Y-m-d H:i:s');
    }
    public function forgetPassword(): ?bool
    {
        $now = date('Y-m-d');
        $now_hour = (int)explode(":", date('H:i:s'))[0];
        if ($this->updateAt !== "") {
            $after = explode(" ", $this->updateAt)[0];
            $after_hour = (int)explode(":", explode(" ", $this->updateAt)[1])[0];
            if ($now === $after && abs($now_hour - $after_hour) < 3) {
                return null;
            }
        }

        $this->token = md5(uniqid(rand(), true));
        $res = $this->save();
        $body_email = "<p>si enviaste este correo presiona <a href='http://uptask.host/restablecer/$this->token'>aquí</a> y restablece tu contraseña</p>";
        $this->sendMail("administrador@ufedev.com", $this->email, $this->nombre, "Restablecer Contraseña", $body_email);
        return $res;
    }
    public function confirm(): ?bool
    {
        $this->token = "";
        $this->confirmado = 1;


        return $this->save();
    }
}
