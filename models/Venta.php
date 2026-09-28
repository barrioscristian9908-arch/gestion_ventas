<?php

class VentaModel{

    private $PDO;


    public function __construct()
    {
        require_once("c://xampp/htdocs/gestion_ventas/config/database.php");

        $con = new db();
        $this->PDO = $con->conexion();
    }


    // 📋 Obtener ventas con filtros
    public function getVentas($filtros = [], $vendedor_id = null){

        $sql = "SELECT
                    v.*,
                    u.nombre AS vendedor_nombre
                FROM ventas v
                INNER JOIN usuarios u
                    ON v.vendedor_id = u.id
                WHERE 1=1";

        $parametros = [];


        // 🔐 Si es vendedor, solamente sus ventas
        if($vendedor_id !== null){

            $sql .= " AND v.vendedor_id = :vendedor_id";

            $parametros[":vendedor_id"] = $vendedor_id;
        }


        // 🔎 Buscar cliente / DNI / teléfono
        if(!empty($filtros["buscar"])){

            $sql .= " AND (
                        v.cliente_nombre LIKE :buscar
                        OR v.cliente_dni LIKE :buscar
                        OR v.cliente_telefono LIKE :buscar
                      )";

            $parametros[":buscar"] =
                "%" . $filtros["buscar"] . "%";
        }


        // 📅 Fecha desde
        if(!empty($filtros["desde"])){

            $sql .= " AND DATE(v.creado_en) >= :desde";

            $parametros[":desde"] =
                $filtros["desde"];
        }


        // 📅 Fecha hasta
        if(!empty($filtros["hasta"])){

            $sql .= " AND DATE(v.creado_en) <= :hasta";

            $parametros[":hasta"] =
                $filtros["hasta"];
        }


        // 💳 Medio de pago
        if(!empty($filtros["medio_pago"])){

            $sql .= " AND v.medio_pago = :medio_pago";

            $parametros[":medio_pago"] =
                $filtros["medio_pago"];
        }


        // 👤 Filtro por vendedor
        if(
            isset($filtros["vendedor_id"]) &&
            $filtros["vendedor_id"] !== ""
        ){

            $sql .= " AND v.vendedor_id = :filtro_vendedor_id";

            $parametros[":filtro_vendedor_id"] =
                $filtros["vendedor_id"];
        }


        $sql .= " ORDER BY v.creado_en DESC";


        $statement = $this->PDO->prepare($sql);


        foreach($parametros as $parametro => $valor){

            $statement->bindValue(
                $parametro,
                $valor
            );
        }


        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    // 👥 Obtener vendedores
    public function getVendedores(){

        $statement = $this->PDO->prepare(
            "SELECT id, nombre
             FROM usuarios
             WHERE rol = 'vendedor'
             AND activo = 1
             ORDER BY nombre ASC"
        );

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    // 📊 Total de ventas según filtros
    public function getTotalVentas($filtros = [], $vendedor_id = null){

        $sql = "SELECT COUNT(*) AS total
                FROM ventas v
                WHERE 1=1";

        $parametros = [];


        if($vendedor_id !== null){

            $sql .= " AND v.vendedor_id = :vendedor_id";

            $parametros[":vendedor_id"] =
                $vendedor_id;
        }


        if(!empty($filtros["buscar"])){

            $sql .= " AND (
                        v.cliente_nombre LIKE :buscar
                        OR v.cliente_dni LIKE :buscar
                        OR v.cliente_telefono LIKE :buscar
                      )";

            $parametros[":buscar"] =
                "%" . $filtros["buscar"] . "%";
        }


        if(!empty($filtros["desde"])){

            $sql .= " AND DATE(v.creado_en) >= :desde";

            $parametros[":desde"] =
                $filtros["desde"];
        }


        if(!empty($filtros["hasta"])){

            $sql .= " AND DATE(v.creado_en) <= :hasta";

            $parametros[":hasta"] =
                $filtros["hasta"];
        }


        if(!empty($filtros["medio_pago"])){

            $sql .= " AND v.medio_pago = :medio_pago";

            $parametros[":medio_pago"] =
                $filtros["medio_pago"];
        }


        if(
            isset($filtros["vendedor_id"]) &&
            $filtros["vendedor_id"] !== ""
        ){

            $sql .= " AND v.vendedor_id = :filtro_vendedor_id";

            $parametros[":filtro_vendedor_id"] =
                $filtros["vendedor_id"];
        }


        $statement = $this->PDO->prepare($sql);


        foreach($parametros as $parametro => $valor){

            $statement->bindValue(
                $parametro,
                $valor
            );
        }


        $statement->execute();

        $resultado =
            $statement->fetch(PDO::FETCH_ASSOC);


        return $resultado["total"] ?? 0;
    }


    // 💰 Monto total según filtros
    public function getTotalMonto($filtros = [], $vendedor_id = null){

        $sql = "SELECT
                    COALESCE(SUM(v.monto), 0) AS total
                FROM ventas v
                WHERE 1=1";

        $parametros = [];


        if($vendedor_id !== null){

            $sql .= " AND v.vendedor_id = :vendedor_id";

            $parametros[":vendedor_id"] =
                $vendedor_id;
        }


        if(!empty($filtros["buscar"])){

            $sql .= " AND (
                        v.cliente_nombre LIKE :buscar
                        OR v.cliente_dni LIKE :buscar
                        OR v.cliente_telefono LIKE :buscar
                      )";

            $parametros[":buscar"] =
                "%" . $filtros["buscar"] . "%";
        }


        if(!empty($filtros["desde"])){

            $sql .= " AND DATE(v.creado_en) >= :desde";

            $parametros[":desde"] =
                $filtros["desde"];
        }


        if(!empty($filtros["hasta"])){

            $sql .= " AND DATE(v.creado_en) <= :hasta";

            $parametros[":hasta"] =
                $filtros["hasta"];
        }


        if(!empty($filtros["medio_pago"])){

            $sql .= " AND v.medio_pago = :medio_pago";

            $parametros[":medio_pago"] =
                $filtros["medio_pago"];
        }


        if(
            isset($filtros["vendedor_id"]) &&
            $filtros["vendedor_id"] !== ""
        ){

            $sql .= " AND v.vendedor_id = :filtro_vendedor_id";

            $parametros[":filtro_vendedor_id"] =
                $filtros["vendedor_id"];
        }


        $statement = $this->PDO->prepare($sql);


        foreach($parametros as $parametro => $valor){

            $statement->bindValue(
                $parametro,
                $valor
            );
        }


        $statement->execute();

        $resultado =
            $statement->fetch(PDO::FETCH_ASSOC);


        return $resultado["total"] ?? 0;
    }


    // 💾 Registrar venta
    public function crear(
        $vendedor_id,
        $cliente_nombre,
        $cliente_dni,
        $cliente_direccion,
        $cliente_telefono,
        $monto,
        $cantidad_chances,
        $medio_pago,
        $comprobante
    ){

        $statement = $this->PDO->prepare(
            "INSERT INTO ventas
            (
                vendedor_id,
                tipo_venta,
                cliente_nombre,
                cliente_dni,
                cliente_direccion,
                cliente_telefono,
                monto,
                cantidad_chances,
                medio_pago,
                comprobante
            )
            VALUES
            (
                :vendedor_id,
                'sorteo',
                :cliente_nombre,
                :cliente_dni,
                :cliente_direccion,
                :cliente_telefono,
                :monto,
                :cantidad_chances,
                :medio_pago,
                :comprobante
            )"
        );


        $statement->bindValue(
            ":vendedor_id",
            $vendedor_id,
            PDO::PARAM_INT
        );

        $statement->bindValue(
            ":cliente_nombre",
            $cliente_nombre
        );

        $statement->bindValue(
            ":cliente_dni",
            $cliente_dni
        );

        $statement->bindValue(
            ":cliente_direccion",
            $cliente_direccion
        );

        $statement->bindValue(
            ":cliente_telefono",
            $cliente_telefono
        );

        $statement->bindValue(
            ":monto",
            $monto
        );

        $statement->bindValue(
            ":cantidad_chances",
            $cantidad_chances,
            PDO::PARAM_INT
        );

        $statement->bindValue(
            ":medio_pago",
            $medio_pago
        );

        $statement->bindValue(
            ":comprobante",
            $comprobante
        );


        return $statement->execute();
    }

}

?>
