<?php

require_once("c://xampp/htdocs/gestion_ventas/models/Venta.php");

class ReportesController{

    private $model;

    public function __construct(){

        $this->model = new VentaModel();

    }


    public function index(){

        // 🔐 Verificar login
        if(!isset($_SESSION["usuario_id"])){

            header(
                "Location: /gestion_ventas/index.php?action=login"
            );

            exit;
        }


        $rol = $_SESSION["rol"] ?? "";

        $usuario_id = $_SESSION["usuario_id"];


        // 📅 Fechas
        $desde = $_GET["desde"] ?? date("Y-m-d");

        $hasta = $_GET["hasta"] ?? date("Y-m-d");


        // 👤 Vendedor
        $vendedor_id = $_GET["vendedor_id"] ?? "";


        // 🔐 El vendedor solamente puede ver sus propias ventas
        if($rol === "vendedor"){

            $vendedor_id = $usuario_id;

        }


        // 📊 Resumen
        $resumen = $this->model->getReporteResumen(
            $desde,
            $hasta,
            $vendedor_id
        );


        // 💳 Medio de pago
        $porMedioPago = $this->model->getReporteMedioPago(
            $desde,
            $hasta,
            $vendedor_id
        );


        // 👥 Ventas por vendedor
        $porVendedor = [];

        if(
            $rol === "admin" ||
            $rol === "operador"
        ){

            $porVendedor =
                $this->model->getReporteVendedores(
                    $desde,
                    $hasta
                );

        }


        // 👤 Lista de vendedores
        $vendedores = [];

        if(
            $rol === "admin" ||
            $rol === "operador"
        ){

            $vendedores =
                $this->model->getVendedores();

        }


        // 📄 Vista
        require_once(
            "c://xampp/htdocs/gestion_ventas/views/reportes/index.php"
        );

    }

}