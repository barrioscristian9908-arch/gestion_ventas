<?php

class UsuarioController{

    private $model;

    public function __construct()
    {
        require_once("c://xampp/htdocs/gestion_ventas/models/Usuarios.php");

        $this->model = new UsuariosModel();
    }


    // 🔐 Verificar que sea administrador
    private function verificarAdmin(){

        if(($_SESSION["rol"] ?? "") !== "admin"){

            $_SESSION["mensaje"] = "Acceso denegado";
            $_SESSION["tipo"] = "danger";

            header("Location: /gestion_ventas/index.php?action=panel");
            exit;
        }
    }


    // 📋 LISTAR USUARIOS
    public function index(){

        $this->verificarAdmin();

        $usuarios = $this->model->getUsuarios();

        require_once("c://xampp/htdocs/gestion_ventas/views/usuarios/index.php");
    }


    // ➕ FORMULARIO CREAR
    public function crear(){

        $this->verificarAdmin();

        require_once("c://xampp/htdocs/gestion_ventas/views/usuarios/crear.php");
    }


    // 💾 GUARDAR USUARIO
    public function store($data){

        $this->verificarAdmin();

        $nombre = trim($data["nombre"] ?? "");
        $usuario = trim($data["usuario"] ?? "");
        $password = $data["password"] ?? "";
        $rol = $data["rol"] ?? "";


        // Validar campos
        if($nombre === "" || $usuario === "" || $password === "" || $rol === ""){

            $_SESSION["mensaje"] = "Completá todos los campos";
            $_SESSION["tipo"] = "danger";

            header("Location: /gestion_ventas/index.php?action=usuarios.crear");
            exit;
        }


        // Validar contraseña
        if(strlen($password) < 6){

            $_SESSION["mensaje"] = "La contraseña debe tener al menos 6 caracteres";
            $_SESSION["tipo"] = "danger";

            header("Location: /gestion_ventas/index.php?action=usuarios.crear");
            exit;
        }


        // Validar rol
        $rolesPermitidos = [
            "admin",
            "vendedor",
            "operador"
        ];

        if(!in_array($rol, $rolesPermitidos)){

            $_SESSION["mensaje"] = "Rol inválido";
            $_SESSION["tipo"] = "danger";

            header("Location: /gestion_ventas/index.php?action=usuarios.crear");
            exit;
        }


        // Verificar usuario existente
        if($this->model->existeUsuario($usuario)){

            $_SESSION["mensaje"] = "El nombre de usuario ya existe";
            $_SESSION["tipo"] = "danger";

            header("Location: /gestion_ventas/index.php?action=usuarios.crear");
            exit;
        }


        // Crear
        $this->model->crear(
            $nombre,
            $usuario,
            $password,
            $rol
        );


        $_SESSION["mensaje"] = "Usuario creado correctamente";
        $_SESSION["tipo"] = "success";

        header("Location: /gestion_ventas/index.php?action=usuarios");
        exit;
    }


    // ✏️ FORMULARIO EDITAR
    public function editar($id){

        $this->verificarAdmin();

        $usuario = $this->model->getUsuario($id);


        // Usuario inexistente
        if(!$usuario){

            $_SESSION["mensaje"] = "Usuario no encontrado";
            $_SESSION["tipo"] = "danger";

            header("Location: /gestion_ventas/index.php?action=usuarios");
            exit;
        }


        require_once("c://xampp/htdocs/gestion_ventas/views/usuarios/editar.php");
    }


    // 💾 ACTUALIZAR USUARIO
    public function update($data){

        $this->verificarAdmin();

        $id = $data["id"] ?? null;

        $nuevo_nombre = trim($data["nombre"] ?? "");
        $nuevo_usuario = trim($data["usuario"] ?? "");
        $nuevo_password = $data["password"] ?? "";
        $nuevo_rol = $data["rol"] ?? "";


        // Validar ID
        if(!$id){

            $_SESSION["mensaje"] = "Usuario inválido";
            $_SESSION["tipo"] = "danger";

            header("Location: /gestion_ventas/index.php?action=usuarios");
            exit;
        }


        // Obtener usuario actual
        $usuarioActual = $this->model->getUsuario($id);


        // Verificar que exista
        if(!$usuarioActual){

            $_SESSION["mensaje"] = "Usuario no encontrado";
            $_SESSION["tipo"] = "danger";

            header("Location: /gestion_ventas/index.php?action=usuarios");
            exit;
        }


        // Validar campos
        if($nuevo_nombre === "" || $nuevo_usuario === "" || $nuevo_rol === ""){

            $_SESSION["mensaje"] = "Completá todos los campos obligatorios";
            $_SESSION["tipo"] = "danger";

            header("Location: /gestion_ventas/index.php?action=usuarios.editar&id=".$id);
            exit;
        }


        // Validar rol
        $rolesPermitidos = [
            "admin",
            "vendedor",
            "operador"
        ];

        if(!in_array($nuevo_rol, $rolesPermitidos)){

            $_SESSION["mensaje"] = "Rol inválido";
            $_SESSION["tipo"] = "danger";

            header("Location: /gestion_ventas/index.php?action=usuarios.editar&id=".$id);
            exit;
        }


        // 🔎 Verificar que el usuario no pertenezca a otra cuenta
        $usuarioExistente = $this->model->getUsuarioPorNombre($nuevo_usuario);

        if($usuarioExistente && $usuarioExistente["id"] != $id){

            $_SESSION["mensaje"] = "El nombre de usuario ya está siendo utilizado";
            $_SESSION["tipo"] = "danger";

            header("Location: /gestion_ventas/index.php?action=usuarios.editar&id=".$id);
            exit;
        }


        // 🔐 Si escribió una nueva contraseña, validar
        if($nuevo_password !== ""){

            if(strlen($nuevo_password) < 6){

                $_SESSION["mensaje"] = "La contraseña debe tener al menos 6 caracteres";
                $_SESSION["tipo"] = "danger";

                header("Location: /gestion_ventas/index.php?action=usuarios.editar&id=".$id);
                exit;
            }

            // Actualizar incluyendo contraseña
            $resultado = $this->model->updateUsuarioConPassword(
                $id,
                $nuevo_nombre,
                $nuevo_usuario,
                $nuevo_password,
                $nuevo_rol
            );

        }else{

            // Actualizar sin cambiar contraseña
            $resultado = $this->model->updateUsuario(
                $id,
                $nuevo_nombre,
                $nuevo_usuario,
                $nuevo_rol
            );
        }


        if($resultado){

            $_SESSION["mensaje"] = "Usuario actualizado correctamente";
            $_SESSION["tipo"] = "success";

        }else{

            $_SESSION["mensaje"] = "No se pudo actualizar el usuario";
            $_SESSION["tipo"] = "danger";
        }


        header("Location: /gestion_ventas/index.php?action=usuarios");
        exit;
    }


    // 🔄 ACTIVAR / DESACTIVAR
    public function estado($data){

        $this->verificarAdmin();

        $id = $data["id"] ?? null;
        $activo = $data["activo"] ?? null;


        if(!$id || ($activo != 0 && $activo != 1)){

            $_SESSION["mensaje"] = "Datos inválidos";
            $_SESSION["tipo"] = "danger";

            header("Location: /gestion_ventas/index.php?action=usuarios");
            exit;
        }


        // 🚫 No permitir desactivar el propio usuario
        if($id == $_SESSION["usuario_id"]){

            $_SESSION["mensaje"] = "No podés desactivar tu propio usuario";
            $_SESSION["tipo"] = "danger";

            header("Location: /gestion_ventas/index.php?action=usuarios");
            exit;
        }


        // Verificar usuario
        $usuario = $this->model->getUsuario($id);

        if(!$usuario){

            $_SESSION["mensaje"] = "El usuario no existe";
            $_SESSION["tipo"] = "danger";

            header("Location: /gestion_ventas/index.php?action=usuarios");
            exit;
        }


        // Cambiar estado
        $this->model->cambiarEstado($id, $activo);


        if($activo == 1){

            $_SESSION["mensaje"] = "Usuario activado correctamente";

        }else{

            $_SESSION["mensaje"] = "Usuario desactivado correctamente";
        }

        $_SESSION["tipo"] = "success";


        header("Location: /gestion_ventas/index.php?action=usuarios");
        exit;
    }

}

?>