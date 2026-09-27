<?php

class AuthController{

    private $model;

    public function __construct()
    {
        require_once("c://xampp/htdocs/gestion_ventas/models/Usuario.php");
        $this->model = new AuthModel();
    }

    public function login($user, $pass){

        $datos = $this->model->login($user, $pass);

        if($datos != false){

            $_SESSION["usuario_id"] = $datos["id"];
            $_SESSION["usuario"] = $datos["usuario"];
            $_SESSION["nombre"] = $datos["nombre"];
            $_SESSION["rol"] = $datos["rol"];

            $_SESSION["mensaje"] = "Bienvenido " . $datos["nombre"];
            $_SESSION["tipo"] = "success";

            header("Location: /gestion_ventas/index.php?action=panel");
            exit;

        }else{

            $_SESSION["mensaje"] = "Usuario o contraseña incorrectas";
            $_SESSION["tipo"] = "danger";

            header("Location: /gestion_ventas/index.php?action=login");
            exit;
        }
    }

    public function logout(){

        session_unset();
        session_destroy();

        header("Location: /gestion_ventas/index.php?action=login");
        exit;
    }

    public function isLogged(){

        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }

        return isset($_SESSION["usuario_id"]);
    }
}
