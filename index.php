<?php

session_start();

// Controllers
require_once("controllers/AuthController.php");
require_once("controllers/PanelController.php");
require_once("controllers/VentaController.php");
require_once("controllers/UsuarioController.php");
require_once("controllers/ReportesController.php");
require_once("controllers/ComisionesController.php");

// Instancia auth
$auth = new AuthController();

// Acción actual
$action = $_GET["action"] ?? "login";

// 🔓 Rutas públicas
$publicRoutes = [
    "login",
    "auth.login"
];

// 🔐 Protección de rutas
if(!in_array($action, $publicRoutes)){

    if(!$auth->isLogged()){

        header(
            "Location: /gestion_ventas/index.php?action=login"
        );

        exit;
    }
}


// 🔐 PERMISOS POR ROL

$permisos = [

    // 👥 USUARIOS
    "usuarios" => [
        "admin"
    ],

    "usuarios.crear" => [
        "admin"
    ],

    "usuarios.store" => [
        "admin"
    ],

    "usuarios.editar" => [
        "admin"
    ],

    "usuarios.update" => [
        "admin"
    ],

    "usuarios.estado" => [
        "admin"
    ],


    // 📊 REPORTES
    "reportes" => [
        "admin",
        "operador"
    ],

    // 💰 COMISIONES
    "comisiones" => [
        "admin"
    ]

];


// 🚫 Verificar permiso

if(isset($permisos[$action])){

    $rol =
        $_SESSION["rol"] ?? "";

    if(!in_array(
        $rol,
        $permisos[$action],
        true
    )){

        $_SESSION["mensaje"] =
            "No tenés permisos para acceder a esta sección";

        $_SESSION["tipo"] =
            "danger";

        header(
            "Location: /gestion_ventas/index.php?action=panel"
        );

        exit;
    }
}


// 🔁 Evitar volver al login si ya está logueado

if(
    $action === "login" &&
    $auth->isLogged()
){

    header(
        "Location: /gestion_ventas/index.php?action=panel"
    );

    exit;
}


// 🚦 Router

switch($action){

    // 🔐 AUTH

    case "login":

        require_once(
            "views/auth/login.php"
        );

        break;


    case "auth.login":

        (new AuthController())->login(
            $_POST["user"],
            $_POST["pass"]
        );

        break;


    case "logout":

        (new AuthController())->logout();

        break;


    // 📊 PANEL

    case "panel":

        (new PanelController())->index();

        break;


    // 👥 USUARIOS

    case "usuarios":

        (new UsuarioController())->index();

        break;


    case "usuarios.crear":

        (new UsuarioController())->crear();

        break;


    case "usuarios.store":

        (new UsuarioController())->store($_POST);

        break;


    case "usuarios.editar":

        (new UsuarioController())->editar(
            $_GET["id"]
        );

        break;


    case "usuarios.update":

        (new UsuarioController())->update(
            $_POST
        );

        break;


    case "usuarios.estado":

        (new UsuarioController())->estado(
            $_POST
        );

        break;


    // 🧾 VENTAS

    case "ventas":

        (new VentaController())->index();

        break;


    case "ventas.exportar":

        (new VentaController())->exportar(
            $_GET
        );

        break;


    case "ventas.crear":

        (new VentaController())->crear();

        break;


    case "ventas.store":

        (new VentaController())->store(
            $_POST
        );

        break;


    case "ventas.editar":

        (new VentaController())->editar(
            $_GET["id"]
        );

        break;


    case "ventas.update":

        (new VentaController())->update(
            $_POST
        );

        break;


    case "ventas.comprobante.agregar":

        (new VentaController())->agregarComprobante(
            $_GET["id"]
        );

        break;


    case "ventas.comprobante.store":

        (new VentaController())->storeComprobante(
            $_POST,
            $_FILES
        );

        break;


    case "ventas.comprobantes":

        (new VentaController())->comprobantes(
            $_GET["id"]
        );

        break;


    case "ventas.comprobante.eliminar":

        (new VentaController())->eliminarComprobante(
            $_GET["id"]
        );

        break;


    // 📊 REPORTES

    case "reportes":

        (new ReportesController())->index();

        break;


    // 💰 COMISIONES

    case "comisiones":

        (new ComisionesController())->index();

        break;


    // ❌ 404

    default:

        echo "404 - Página no encontrada";

        break;
}

?>