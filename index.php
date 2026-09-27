<?php

session_start();

// Controllers
require_once("controllers/AuthController.php");
require_once("controllers/PanelController.php");
require_once("controllers/VentaController.php");

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
        header("Location: /gestion_ventas/index.php?action=login");
        exit;
    }
}

// 🔁 Evitar volver al login si ya está logueado
if($action === "login" && $auth->isLogged()){
    header("Location: /gestion_ventas/index.php?action=panel");
    exit;
}

// 🚦 Router
switch($action){

    // 🔐 AUTH
    case "login":
        require_once("views/auth/login.php");
        break;

    case "auth.login":
        (new AuthController())->login($_POST["user"], $_POST["pass"]);
        break;

    case "logout":
        (new AuthController())->logout();
        break;


    // 📊 PANEL
    case "panel":
        (new PanelController())->index();
        break;


    // 🧾 VENTAS
    case "ventas":
        (new VentaController())->index();
        break;

    case "ventas.crear":
        (new VentaController())->crear();
        break;

    case "ventas.store":
        (new VentaController())->store($_POST);
        break;


    // 📊 REPORTES
    // Lo agregaremos cuando hagamos las comisiones
    /*
    case "reportes":
        (new ReporteController())->index();
        break;
    */


    // ❌ 404
    default:
        echo "404 - Página no encontrada";
        break;
}