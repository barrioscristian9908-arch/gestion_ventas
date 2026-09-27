<?php

class PanelController{

    private $model;

    public function __construct()
    {
        require_once("c://xampp/htdocs/gestion_ventas/models/Panel.php");

        $this->model = new PanelModel();
    }

    public function index(){

        $usuario_id = $_SESSION["usuario_id"];
        $rol = $_SESSION["rol"];

        // Si es vendedor, mostramos solamente sus ventas
        if($rol === "vendedor"){

            $totalVentas = $this->model->getTotalVentas($usuario_id);
            $totalMonto = $this->model->getTotalMonto($usuario_id);

        }else{

            // Admin y operador ven las ventas generales
            $totalVentas = $this->model->getTotalVentas();
            $totalMonto = $this->model->getTotalMonto();
        }

        require_once("c://xampp/htdocs/gestion_ventas/views/panel.php");
    }
}