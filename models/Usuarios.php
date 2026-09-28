<?php

class UsuariosModel{

    private $PDO;

    public function __construct()
    {
        require_once("c://xampp/htdocs/gestion_ventas/config/database.php");

        $con = new db();
        $this->PDO = $con->conexion();
    }


    // 📋 Obtener todos los usuarios
    public function getUsuarios(){

        $statement = $this->PDO->prepare(
            "SELECT id, nombre, usuario, rol, activo, creado_en
             FROM usuarios
             ORDER BY id DESC"
        );

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    // 🔎 Verificar si existe un usuario
    public function existeUsuario($usuario){

        $statement = $this->PDO->prepare(
            "SELECT id
             FROM usuarios
             WHERE usuario = :usuario
             LIMIT 1"
        );

        $statement->bindParam(":usuario", $usuario);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC) !== false;
    }


    // ➕ Crear usuario
    public function crear($nombre, $usuario, $password, $rol){

        $passwordHash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $statement = $this->PDO->prepare(
            "INSERT INTO usuarios
            (nombre, usuario, password, rol)
            VALUES
            (:nombre, :usuario, :password, :rol)"
        );

        $statement->bindParam(":nombre", $nombre);
        $statement->bindParam(":usuario", $usuario);
        $statement->bindParam(":password", $passwordHash);
        $statement->bindParam(":rol", $rol);

        return $statement->execute();
    }


    // 🔎 Obtener usuario por ID
    public function getUsuario($id){

        $statement = $this->PDO->prepare(
            "SELECT id, nombre, usuario, rol, activo, creado_en
             FROM usuarios
             WHERE id = :id
             LIMIT 1"
        );

        $statement->bindParam(":id", $id);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }


    // 🔎 Obtener usuario por nombre de usuario
    public function getUsuarioPorNombre($usuario){

        $statement = $this->PDO->prepare(
            "SELECT id, nombre, usuario, rol, activo
             FROM usuarios
             WHERE usuario = :usuario
             LIMIT 1"
        );

        $statement->bindParam(":usuario", $usuario);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }


    // ✏️ Actualizar sin cambiar contraseña
    public function updateUsuario($id, $nombre, $usuario, $rol){

        $statement = $this->PDO->prepare(
            "UPDATE usuarios
             SET nombre = :nombre,
                 usuario = :usuario,
                 rol = :rol
             WHERE id = :id"
        );

        $statement->bindParam(":nombre", $nombre);
        $statement->bindParam(":usuario", $usuario);
        $statement->bindParam(":rol", $rol);
        $statement->bindParam(":id", $id);

        return $statement->execute();
    }


    // 🔐 Actualizar incluyendo nueva contraseña
    public function updateUsuarioConPassword(
        $id,
        $nombre,
        $usuario,
        $password,
        $rol
    ){

        $passwordHash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $statement = $this->PDO->prepare(
            "UPDATE usuarios
             SET nombre = :nombre,
                 usuario = :usuario,
                 password = :password,
                 rol = :rol
             WHERE id = :id"
        );

        $statement->bindParam(":nombre", $nombre);
        $statement->bindParam(":usuario", $usuario);
        $statement->bindParam(":password", $passwordHash);
        $statement->bindParam(":rol", $rol);
        $statement->bindParam(":id", $id);

        return $statement->execute();
    }


    // 🔄 Activar / desactivar
    public function cambiarEstado($id, $activo){

        $statement = $this->PDO->prepare(
            "UPDATE usuarios
             SET activo = :activo
             WHERE id = :id"
        );

        $statement->bindParam(":activo", $activo);
        $statement->bindParam(":id", $id);

        return $statement->execute();
    }

}

?>