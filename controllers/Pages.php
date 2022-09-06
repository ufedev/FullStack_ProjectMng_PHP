<?php

namespace Controllers;

use Models\Usuarios;
use Ufe\RouterFS as Ro;

class Pages
{


    public static function login(Ro $router): void
    {
        no_auth();
        $alertas = null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = htmlspecialchars($_POST["email"]);
            $password = htmlspecialchars($_POST["password"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $alertas = "Email no válido";
            } else {
                $user = Usuarios::findOneBy("email", $email);
                if (!$user) {
                    $alertas = "Usuario y/o contraseña no válidos";
                }

                if (!$alertas) {
                    $checkPass = password_verify($password, $user->password);
                    if ($checkPass) {
                        $_SESSION['id'] = $user->id;
                        $_SESSION['login'] = true;
                        $_SESSION['nombre'] = $user->nombre;
                        $_SESSION['email'] = $user->email;
                        header("location: /proyectos");
                    } else {
                        $alertas = "Usuario y/o contraseña no válidos";
                    }
                }
            }
        }

        $content = __DIR__ . "/../views/pages/login.php";
        $router->render($content, [
            "titulo" => "Inicia Sesión",
            "alertas" => $alertas,
            "clase" => null
        ], LAYOUT);
    }
    public static function logout(Ro $router): void
    {
        $_SESSION = [];
        auth();
    }
    public static function registrar(Ro $router): void
    {
        no_auth();
        $nuevo_registro = new Usuarios();
        $alertas = null;
        $clase = null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nuevo_registro = new Usuarios($_POST);

            $alertas = $nuevo_registro->validate($_POST["password2"]);

            if (!$alertas) {
                $nuevo_registro->prepareToSave();
                $res = $nuevo_registro->save();
                $bodyEmail = "<p>Has click aqui y verifica tu email <a href='http://uptask.host/confirmar/$nuevo_registro->token'>Confirmar</a></p>";
                $nuevo_registro->sendMail("correo@correo.com", $nuevo_registro->email, $nuevo_registro->nombre, "Confirma tu Cuenta", $bodyEmail);
                if ($res) {
                    header("Location: /registro-exitoso");
                } else {
                    $alertas = "Hubo un error";
                }
            }
        }


        $content = __DIR__ . "/../views/pages/registro.php";
        $router->render($content, [
            "titulo" => "Crear Cuenta",
            "alertas" => $alertas,
            "registro" => $nuevo_registro,
            "clase" => $clase
        ], LAYOUT);
    }
    public static function registroExitoso(Ro $router): void
    {
        no_auth();
        $content = __DIR__ . "/../views/pages/registroExito.php";
        $router->render($content, [
            "titulo" => "Registrado!"
        ], LAYOUT);
        header("refresh:5;url= /");
    }
    public static function confirmar(Ro $router): void
    {

        $token = htmlspecialchars($_GET["token"]) ?? null;
        $user = Usuarios::findOneBy("token", $token);
        $titulo_confirmar = "";
        $clase = null;
        $msg = "";
        if ($token && $user) {


            $titulo_confirmar = "Su cuenta se pudo";
            $clase = "exito";
            $msg = "Su usuario ha sido confimado ya puede <a class='link' href='/'>iniciar sesión</a>";
            $user->confirm();
        } else {
            $titulo_confirmar = "Hubo un error al intentar ";
            $msg = "Token no válido";
            header("refresh:5; url=/");
        }
        $content = __DIR__ . "/../views/pages/confirmar.php";
        $router->render($content, [
            "titulo" => "Confirmar Cuenta",
            "titulo_confirmar" => $titulo_confirmar,
            "clase" => $clase,
            "msg" => $msg
        ], LAYOUT);
    }
    public static function olvide(Ro $router): void
    {
        no_auth();
        $clase = null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = htmlspecialchars($_POST["email"]) ?? null;
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $user = Usuarios::findOneBy("email", $email);

                if ($user && $email) {
                    $res = $user->forgetPassword();

                    if ($res) {
                        $alertas = "Se ha enviado un mensaje a su casilla de Correo";
                        $clase = "exito";
                        header("refresh:5;url=/");
                    } else {
                        $alertas = "El correo ya ha sido enviado o la cuenta ha sido confirmada hace breve";
                    }
                } else {
                    $alertas = "El email es inexistente o Erroneo";
                }
            } else {
                $alertas = "El email no es válido";
            }
        }
        $content = __DIR__ . "/../views/pages/olvide.php";
        $router->render($content, [
            "titulo" => "Olvide Pass",
            "alertas" => $alertas ?? null,
            "clase" => $clase
        ], LAYOUT);
    }
    public static function restablecer(Ro $router): void
    {
        no_auth();
        $alertas = null;
        $clase = null;
        $token = htmlspecialchars($_GET['token']) ?? null;
        $user = Usuarios::findOneBy("token", $token);
        if ($token && $user) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
            }
        } else {
            $alertas = "Token no válido";
            header("refresh:5;url=/");
        }

        $content = __DIR__ . "/../views/pages/restablecer.php";
        $router->render($content, [
            "titulo" => "restablecer",
            "alertas" => $alertas,
            "clase" => $clase
        ], LAYOUT);
    }
}
