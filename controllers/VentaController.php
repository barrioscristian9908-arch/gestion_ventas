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


        // 🔎 Validar datos obligatorios
        // DNI es opcional
        // Dirección es obligatoria
        if(
            $cliente_nombre === "" ||
            $cliente_direccion === "" ||
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
            "Tarjeta",
            "Pago combinado"
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


        // 💾 Guardar venta
        // No se guarda ningún comprobante todavía
        $resultado =
            $this->model->crear(
                $vendedor_id,
                $cliente_nombre,
                $cliente_dni,
                $cliente_direccion,
                $cliente_telefono,
                $monto,
                $cantidad_chances,
                $medio_pago
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

    public function editar($id){

        $this->verificarLogin();

        // Solamente vendedores
        if(($_SESSION["rol"] ?? "") !== "vendedor"){

            $_SESSION["mensaje"] =
                "No tenés permisos para editar ventas";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas"
            );

            exit;
        }

        $vendedor_id =
            $_SESSION["usuario_id"];


        // Buscar venta
        $venta =
            $this->model->getVentaPorId(
                $id,
                $vendedor_id
            );


        // Si no existe o no pertenece al vendedor
        if(!$venta){

            $_SESSION["mensaje"] =
                "La venta no existe o no tenés permisos para editarla";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas"
            );

            exit;
        }


        require_once(
            "c://xampp/htdocs/gestion_ventas/views/ventas/editar.php"
        );
    }

    public function update($data){

        $this->verificarLogin();

        // Solamente vendedores
        if(($_SESSION["rol"] ?? "") !== "vendedor"){

            $_SESSION["mensaje"] =
                "No tenés permisos para editar ventas";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas"
            );

            exit;
        }


        $vendedor_id =
            $_SESSION["usuario_id"];


        // 📋 Datos
        $id =
            $data["id"] ?? "";

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


        // 🔎 Datos obligatorios
        // DNI es opcional
        if(
            $id === "" ||
            $cliente_nombre === "" ||
            $cliente_direccion === "" ||
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
                "Location: /gestion_ventas/index.php?action=ventas.editar&id="
                . (int)$id
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
                "Location: /gestion_ventas/index.php?action=ventas.editar&id="
                . (int)$id
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
                "Location: /gestion_ventas/index.php?action=ventas.editar&id="
                . (int)$id
            );

            exit;
        }


        // 💳 Medios de pago permitidos
        $mediosPermitidos = [
            "Efectivo",
            "Transferencia",
            "Mercado Pago",
            "Tarjeta",
            "Pago combinado"
        ];

        if(!in_array($medio_pago, $mediosPermitidos)){

            $_SESSION["mensaje"] =
                "El medio de pago seleccionado no es válido";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas.editar&id="
                . (int)$id
            );

            exit;
        }


        // 💾 Actualizar venta
        $resultado =
            $this->model->actualizar(
                $id,
                $vendedor_id,
                $cliente_nombre,
                $cliente_dni,
                $cliente_direccion,
                $cliente_telefono,
                $monto,
                $cantidad_chances,
                $medio_pago
            );


        if($resultado){

            $_SESSION["mensaje"] =
                "Venta actualizada correctamente";

            $_SESSION["tipo"] =
                "success";

            header(
                "Location: /gestion_ventas/index.php?action=ventas"
            );

            exit;

        }else{

            $_SESSION["mensaje"] =
                "No se pudo actualizar la venta";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas.editar&id="
                . (int)$id
            );

            exit;
        }
    }

    public function agregarComprobante($id){

        $this->verificarLogin();

        // Solamente vendedores
        if(($_SESSION["rol"] ?? "") !== "vendedor"){

            $_SESSION["mensaje"] =
                "No tenés permisos para agregar comprobantes";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas"
            );

            exit;
        }


        $vendedor_id =
            $_SESSION["usuario_id"];


        // Buscar la venta y verificar que sea del vendedor
        $venta =
            $this->model->getVentaPorId(
                $id,
                $vendedor_id
            );


        if(!$venta){

            $_SESSION["mensaje"] =
                "La venta no existe o no tenés permisos para modificarla";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas"
            );

            exit;
        }


        require_once(
            "c://xampp/htdocs/gestion_ventas/views/ventas/comprobante_agregar.php"
        );
    }

    public function storeComprobante($data, $files){

        $this->verificarLogin();

        // Solamente vendedores
        if(($_SESSION["rol"] ?? "") !== "vendedor"){

            $_SESSION["mensaje"] =
                "No tenés permisos para agregar comprobantes";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas"
            );

            exit;
        }


        $vendedor_id =
            $_SESSION["usuario_id"];


        $venta_id =
            $data["venta_id"] ?? "";


        // Verificar que la venta exista y pertenezca al vendedor
        $venta =
            $this->model->getVentaPorId(
                $venta_id,
                $vendedor_id
            );


        if(!$venta){

            $_SESSION["mensaje"] =
                "La venta no existe o no tenés permisos para modificarla";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas"
            );

            exit;
        }


        // Verificar archivo
        if(
            !isset($files["comprobante"]) ||
            $files["comprobante"]["error"] !== UPLOAD_ERR_OK
        ){

            $_SESSION["mensaje"] =
                "Seleccioná un comprobante válido";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas.comprobante.agregar&id="
                . (int)$venta_id
            );

            exit;
        }


        $archivo =
            $files["comprobante"];


        // 📁 Extensiones permitidas
        $extensionesPermitidas = [
            "jpg",
            "jpeg",
            "png",
            "webp",
            "pdf"
        ];


        $extension =
            strtolower(
                pathinfo(
                    $archivo["name"],
                    PATHINFO_EXTENSION
                )
            );


        if(!in_array($extension, $extensionesPermitidas, true)){

            $_SESSION["mensaje"] =
                "El archivo debe ser JPG, JPEG, PNG, WEBP o PDF";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas.comprobante.agregar&id="
                . (int)$venta_id
            );

            exit;
        }


        // 📦 Tamaño máximo: 10 MB
        if($archivo["size"] > 10 * 1024 * 1024){

            $_SESSION["mensaje"] =
                "El comprobante no puede superar los 10 MB";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas.comprobante.agregar&id="
                . (int)$venta_id
            );

            exit;
        }


        // 📁 Carpeta de comprobantes
        $carpeta =
            "c://xampp/htdocs/gestion_ventas/uploads/comprobantes/";


        // Crear carpeta si no existe
        if(!is_dir($carpeta)){

            mkdir(
                $carpeta,
                0777,
                true
            );
        }


        // 🔐 Nombre único
        $nombreArchivo =
            uniqid("comprobante_", true)
            . "."
            . $extension;


        $rutaDestino =
            $carpeta . $nombreArchivo;


        // 📤 Mover archivo
        if(!move_uploaded_file(
            $archivo["tmp_name"],
            $rutaDestino
        )){

            $_SESSION["mensaje"] =
                "No se pudo guardar el comprobante";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas.comprobante.agregar&id="
                . (int)$venta_id
            );

            exit;
        }


        // 💾 Guardar registro en BD
        $resultado =
            $this->model->agregarComprobante(
                $venta_id,
                $nombreArchivo
            );


        if($resultado){

            $_SESSION["mensaje"] =
                "Comprobante agregado correctamente";

            $_SESSION["tipo"] =
                "success";

            header(
                "Location: /gestion_ventas/index.php?action=ventas"
            );

            exit;

        }


        // Si falló la BD, eliminar el archivo que acabamos de subir
        if(file_exists($rutaDestino)){

            unlink($rutaDestino);
        }


        $_SESSION["mensaje"] =
            "No se pudo registrar el comprobante";

        $_SESSION["tipo"] =
            "danger";

        header(
            "Location: /gestion_ventas/index.php?action=ventas.comprobante.agregar&id="
            . (int)$venta_id
        );

        exit;
    }

    public function comprobantes($id){

        $this->verificarLogin();

        $rol =
            $_SESSION["rol"] ?? "";

        $vendedor_id =
            $_SESSION["usuario_id"];


        // Buscar la venta
        if($rol === "vendedor"){

            // El vendedor solamente puede ver sus propias ventas
            $venta =
                $this->model->getVentaPorId(
                    $id,
                    $vendedor_id
                );

        }else{

            // Admin y operador pueden ver cualquier venta
            $venta =
                $this->model->getVentaPorIdAdmin($id);

        }


        if(!$venta){

            $_SESSION["mensaje"] =
                "La venta no existe o no tenés permisos para verla";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas"
            );

            exit;
        }


        // Obtener comprobantes
        $comprobantes =
            $this->model->getComprobantes($id);


        require_once(
            "c://xampp/htdocs/gestion_ventas/views/ventas/comprobantes.php"
        );
    }

    public function eliminarComprobante($id){

        $this->verificarLogin();


        // Solamente vendedores
        if(($_SESSION["rol"] ?? "") !== "vendedor"){

            $_SESSION["mensaje"] =
                "No tenés permisos para eliminar comprobantes";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas"
            );

            exit;
        }


        $vendedor_id =
            $_SESSION["usuario_id"];


        // Buscar comprobante y comprobar que pertenece
        // a una venta del vendedor
        $comprobante =
            $this->model->getComprobantePorId(
                $id,
                $vendedor_id
            );


        if(!$comprobante){

            $_SESSION["mensaje"] =
                "El comprobante no existe o no tenés permisos para eliminarlo";

            $_SESSION["tipo"] =
                "danger";

            header(
                "Location: /gestion_ventas/index.php?action=ventas"
            );

            exit;
        }


        // Ruta física del archivo
        $rutaArchivo =
            "c://xampp/htdocs/gestion_ventas/uploads/comprobantes/"
            . $comprobante["archivo"];


        // Eliminar archivo físico
        if(file_exists($rutaArchivo)){

            unlink($rutaArchivo);
        }


        // Eliminar registro de BD
        $resultado =
            $this->model->eliminarComprobante(
                $id,
                $vendedor_id
            );


        if($resultado){

            $_SESSION["mensaje"] =
                "Comprobante eliminado correctamente";

            $_SESSION["tipo"] =
                "success";

        }else{

            $_SESSION["mensaje"] =
                "No se pudo eliminar el comprobante";

            $_SESSION["tipo"] =
                "danger";
        }


        // Volver a la venta
        $venta_id =
            $comprobante["venta_id"];


        header(
            "Location: /gestion_ventas/index.php?action=ventas.comprobantes&id="
            . (int)$venta_id
        );

        exit;
    }

}

?>
