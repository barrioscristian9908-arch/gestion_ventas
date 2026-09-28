<?php

class VentaController{

    private $model;


    public function __construct()
    {
        require_once("c://xampp/htdocs/gestion_ventas/models/Venta.php");

        $this->model = new VentaModel();
    }


    // 🔐 Verificar que el usuario esté logueado
    private function verificarLogin(){

        if(!isset($_SESSION["usuario_id"])){

            header(
                "Location: /gestion_ventas/index.php?action=login"
            );

            exit;
        }
    }


    // 📋 LISTAR VENTAS
    public function index(){

        $this->verificarLogin();


        $rol = $_SESSION["rol"] ?? "";

        $usuario_id =
            $_SESSION["usuario_id"] ?? null;


        // 🔎 Filtros
        $filtros = [

            "buscar" =>
                trim($_GET["buscar"] ?? ""),

            "desde" =>
                $_GET["desde"] ?? "",

            "hasta" =>
                $_GET["hasta"] ?? "",

            "medio_pago" =>
                $_GET["medio_pago"] ?? "",

            "vendedor_id" =>
                $_GET["vendedor_id"] ?? ""
        ];


        // 👤 VENDEDOR
        if($rol === "vendedor"){

            $ventas =
                $this->model->getVentas(
                    $filtros,
                    $usuario_id
                );

            $totalVentas =
                $this->model->getTotalVentas(
                    $filtros,
                    $usuario_id
                );

            $totalMonto =
                $this->model->getTotalMonto(
                    $filtros,
                    $usuario_id
                );

            $vendedores = [];

        }


        // 🛡️ ADMIN / OPERADOR
        elseif(
            $rol === "admin" ||
            $rol === "operador"
        ){

            $ventas =
                $this->model->getVentas(
                    $filtros
                );

            $totalVentas =
                $this->model->getTotalVentas(
                    $filtros
                );

            $totalMonto =
                $this->model->getTotalMonto(
                    $filtros
                );


            if($rol === "admin"){

                $vendedores =
                    $this->model->getVendedores();

            }else{

                $vendedores = [];

            }

        }


        // ❌ ROL INVÁLIDO
        else{

            $_SESSION["mensaje"] =
                "No tenés permisos para acceder a las ventas";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=panel"
            );

            exit;
        }


        require_once(
            "c://xampp/htdocs/gestion_ventas/views/ventas/index.php"
        );
    }


    // ➕ FORMULARIO CREAR VENTA
    public function crear(){

        $this->verificarLogin();


        // Solamente vendedores pueden registrar
        if(($_SESSION["rol"] ?? "") !== "vendedor"){

            $_SESSION["mensaje"] =
                "No tenés permisos para registrar ventas";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas"
            );

            exit;
        }


        require_once(
            "c://xampp/htdocs/gestion_ventas/views/ventas/crear.php"
        );
    }


    // 💾 GUARDAR VENTA
    public function store($data){

        $this->verificarLogin();


        // Solamente vendedores
        if(($_SESSION["rol"] ?? "") !== "vendedor"){

            $_SESSION["mensaje"] =
                "No tenés permisos para registrar ventas";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas"
            );

            exit;
        }


        // 👤 Vendedor logueado
        $vendedor_id =
            $_SESSION["usuario_id"];


        // 📋 Datos
        $cliente_nombre =
            trim($data["cliente_nombre"] ?? "");

        $cliente_dni =
            trim($data["cliente_dni"] ?? "");

        $cliente_direccion =
            trim($data["cliente_direccion"] ?? "");

        $cliente_telefono =
            trim($data["cliente_telefono"] ?? "");

        $monto =
            $data["monto"] ?? "";

        $cantidad_chances =
            $data["cantidad_chances"] ?? "";

        $medio_pago =
            $data["medio_pago"] ?? "";


        // 📎 Comprobante
        $archivo =
            $_FILES["comprobante"] ?? null;


        // 🔎 Validar datos obligatorios
        if(
            $cliente_nombre === "" ||
            $cliente_dni === "" ||
            $cliente_telefono === "" ||
            $monto === "" ||
            $cantidad_chances === "" ||
            $medio_pago === ""
        ){

            $_SESSION["mensaje"] =
                "Completá todos los campos obligatorios";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas.crear"
            );

            exit;
        }


        // 🎟️ Validar cantidad de chances
        if(
            !is_numeric($cantidad_chances) ||
            (int)$cantidad_chances < 1
        ){

            $_SESSION["mensaje"] =
                "La cantidad de chances no es válida";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas.crear"
            );

            exit;
        }


        $cantidad_chances =
            (int)$cantidad_chances;


        // 💰 Montos permitidos
        $montosPermitidos = [
            "10000",
            "15000",
            "20000",
            "30000",
            "50000",
            "75000",
            "100000"
        ];


        if(!in_array((string)$monto, $montosPermitidos, true)){

            $_SESSION["mensaje"] =
                "El monto seleccionado no es válido";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas.crear"
            );

            exit;
        }


        // 💳 Medios de pago permitidos
        $mediosPermitidos = [
            "Efectivo",
            "Transferencia",
            "Mercado Pago",
            "Tarjeta"
        ];


        if(!in_array($medio_pago, $mediosPermitidos, true)){

            $_SESSION["mensaje"] =
                "El medio de pago seleccionado no es válido";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas.crear"
            );

            exit;
        }


        // 📎 Verificar comprobante
        if(
            !$archivo ||
            !isset($archivo["error"]) ||
            $archivo["error"] !== UPLOAD_ERR_OK
        ){

            $_SESSION["mensaje"] =
                "Tenés que adjuntar el comprobante";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas.crear"
            );

            exit;
        }


        // 📦 Tamaño máximo: 5 MB
        $maximo =
            5 * 1024 * 1024;


        if($archivo["size"] > $maximo){

            $_SESSION["mensaje"] =
                "El comprobante no puede superar los 5 MB";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas.crear"
            );

            exit;
        }


        // 🔎 Detectar MIME real
        $finfo =
            new finfo(FILEINFO_MIME_TYPE);

        $mime =
            $finfo->file($archivo["tmp_name"]);


        $tiposPermitidos = [

            "image/jpeg" => "jpg",
            "image/png"  => "png",
            "application/pdf" => "pdf"

        ];


        if(!isset($tiposPermitidos[$mime])){

            $_SESSION["mensaje"] =
                "El comprobante debe ser JPG, PNG o PDF";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas.crear"
            );

            exit;
        }


        // 📁 Carpeta por año/mes
        $año =
            date("Y");

        $mes =
            date("m");


        $carpetaFisica =
            "c://xampp/htdocs/gestion_ventas/public/uploads/comprobantes/"
            . $año . "/"
            . $mes . "/";


        // Crear carpeta si no existe
        if(!is_dir($carpetaFisica)){

            if(!mkdir($carpetaFisica, 0755, true)){

                $_SESSION["mensaje"] =
                    "No se pudo crear la carpeta para el comprobante";

                $_SESSION["tipo"] =
                    "danger";

                header(
                    "Location: /gestion_ventas/index.php?action=ventas.crear"
                );

                exit;
            }
        }


        // 🔐 Nombre único
        $nombreArchivo =
            bin2hex(random_bytes(16))
            . "."
            . $tiposPermitidos[$mime];


        $rutaFisica =
            $carpetaFisica
            . $nombreArchivo;


        // 💾 Mover archivo
        if(!move_uploaded_file(
            $archivo["tmp_name"],
            $rutaFisica
        )){

            $_SESSION["mensaje"] =
                "No se pudo guardar el comprobante";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas.crear"
            );

            exit;
        }


        // 🗂️ Ruta que se guarda en la BD
        $rutaBD =
            "public/uploads/comprobantes/"
            . $año . "/"
            . $mes . "/"
            . $nombreArchivo;


        // 💾 Guardar venta
        $resultado =
            $this->model->crear(
                $vendedor_id,
                $cliente_nombre,
                $cliente_dni,
                $cliente_direccion,
                $cliente_telefono,
                $monto,
                $cantidad_chances,
                $medio_pago,
                $rutaBD
            );


        if($resultado){

            $_SESSION["mensaje"] =
                "Venta registrada correctamente";

            $_SESSION["tipo"] =
                "success";


            header(
                "Location: /gestion_ventas/index.php?action=ventas"
            );

            exit;

        }else{

            // Si falló la BD, eliminar el archivo
            if(file_exists($rutaFisica)){

                unlink($rutaFisica);
            }


            $_SESSION["mensaje"] =
                "No se pudo registrar la venta";

            $_SESSION["tipo"] =
                "danger";


            header(
                "Location: /gestion_ventas/index.php?action=ventas.crear"
            );

            exit;
        }

    }

}

?>
