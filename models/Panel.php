<?php

class PanelModel{

    private $PDO;

    public function __construct()
    {
        require_once("c://xampp/htdocs/gestion_ventas/config/database.php");

        $con = new db();
        $this->PDO = $con->conexion();
    }


    // Cantidad de ventas
    // Si se pasa un usuario_id, cuenta solamente sus ventas.
    // Si no se pasa, cuenta todas.
    public function getTotalVentas($usuario_id = null){

        if($usuario_id !== null){

            $statement = $this->PDO->prepare(
                "SELECT COUNT(*) AS total
                 FROM ventas
                 WHERE vendedor_id = :id"
            );

            $statement->bindParam(":id", $usuario_id);

        }else{

            $statement = $this->PDO->prepare(
                "SELECT COUNT(*) AS total
                 FROM ventas"
            );
        }

        $statement->execute();

        $resultado = $statement->fetch(PDO::FETCH_ASSOC);

        return $resultado["total"] ?? 0;
    }


    // Monto total de ventas
    // Si se pasa un usuario_id, suma solamente sus ventas.
    // Si no se pasa, suma todas.
    public function getTotalMonto($usuario_id = null){

        if($usuario_id !== null){

            $statement = $this->PDO->prepare(
                "SELECT COALESCE(SUM(monto), 0) AS total
                 FROM ventas
                 WHERE vendedor_id = :id"
            );

            $statement->bindParam(":id", $usuario_id);

        }else{

            $statement = $this->PDO->prepare(
                "SELECT COALESCE(SUM(monto), 0) AS total
                 FROM ventas"
            );
        }

        $statement->execute();

        $resultado = $statement->fetch(PDO::FETCH_ASSOC);

        return $resultado["total"] ?? 0;
    }

}
?>