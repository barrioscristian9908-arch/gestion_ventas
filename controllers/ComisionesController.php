<?php

require_once("c://xampp/htdocs/gestion_ventas/models/Venta.php");

class ComisionesController{

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


        // 👤 Lista de vendedores
        $vendedores = [];

        if(
            $rol === "admin" ||
            $rol === "operador"
        ){

            $vendedores =
                $this->model->getVendedores();

        }


        // 📊 Estado del cálculo
        $calculado = isset($_GET["desde"]) || isset($_GET["hasta"]);


        // 📋 Ventas
        $ventas = [];


        if($calculado){

            $filtros = [

                "desde" => $desde,

                "hasta" => $hasta,

                "vendedor_id" => $vendedor_id

            ];


            $ventas =
                $this->model->getVentas(
                    $filtros,
                    $vendedor_id
                );


            // 💰 Calcular comisión de cada venta

            foreach($ventas as &$venta){

                $monto = (float)$venta["monto"];

                $comision = 0;


                switch($monto){

                    case 10000:
                        $comision = 3000;
                        break;

                    case 20000:
                        $comision = 5000;
                        break;

                    case 30000:
                        $comision = 7500;
                        break;

                    case 50000:
                        $comision = 10000;
                        break;

                    case 75000:
                        $comision = 15000;
                        break;

                    case 100000:
                        $comision = 20000;
                        break;

                }


                $venta["comision"] = $comision;

            }

            unset($venta);


        }


        // 📊 Resumen

        $totalVentas = count($ventas);

        $totalMonto = 0;

        $totalComision = 0;


        foreach($ventas as $venta){

            $totalMonto += (float)$venta["monto"];

            $totalComision += (float)$venta["comision"];

        }


        $resumen = [

            "total_ventas" => $totalVentas,

            "total_monto" => $totalMonto,

            "total_comision" => $totalComision

        ];


        // 📄 Vista

        require_once(
            "c://xampp/htdocs/gestion_ventas/views/comisiones/index.php"
        );

    }

}