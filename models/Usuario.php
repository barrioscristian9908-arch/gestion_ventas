<?php

class AuthModel{

    private $PDO;

    public function __construct()
    {
        require_once("c://xampp/htdocs/gestion_ventas/config/database.php");

        $con = new db();
        $this->PDO = $con->conexion();
    }

    public function login($user, $pass){

        $statement = $this->PDO->prepare(
            "SELECT id, nombre, usuario, password, rol, activo
             FROM usuarios
             WHERE usuario = :usuario
             LIMIT 1"
        );

        $statement->bindParam(":usuario", $user);

        if($statement->execute()){

            $usuario = $statement->fetch(PDO::FETCH_ASSOC);

            if($usuario){

                // Verificar si el usuario está activo
                if($usuario["activo"] != 1){
                    return false;
                }

                // Verificar contraseña
                if(password_verify($pass, $usuario["password"])){

                    return $usuario;
                }
            }
        }

        return false;
    }
}
?>