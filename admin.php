<?php

require_once 'config/database.php';

$db = new db();
$conexion = $db->conexion();

$nombre = "Administrador";
$usuario = "admin";
$password = "admin123";

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nombre, usuario, password, rol)
        VALUES (:nombre, :usuario, :password, 'admin')";

$stmt = $conexion->prepare($sql);

$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':usuario', $usuario);
$stmt->bindParam(':password', $password_hash);

if ($stmt->execute()) {
    echo "Administrador creado correctamente.";
} else {
    echo "Error al crear el administrador.";
}