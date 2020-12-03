<?php

require_once "_Varios.php";
session_start();
$pdo = obtenerPdoConexionBD();

$id = $_REQUEST["id"];
$identificador = $_REQUEST["identificador"];
$contrasenna = $_REQUEST["contrasenna"];
$nombre = $_REQUEST["nombre"];
$apellidos = $_REQUEST["apellidos"];

//Si no existe sesión = se quiere crear un usuario
if(!isset($_SESSION["id"])){
    $sql = "INSERT INTO Usuario (identificador, contrasenna, codigoCookie, tipoUsuario, nombre, apellidos) VALUES (?, ?, ?, ?, ?, ?)";
    $parametros = [$identificador, $contrasenna, null, 0, $nombre, $apellidos];
} else {
    $sql = "UPDATE Usuario SET identificador=?, contrasenna=?, nombre=?, apellidos=? WHERE id=?";
    $parametros = [$identificador, $contrasenna, $nombre, $apellidos, $id];
}

$sentencia = $pdo->prepare($sql);

$sqlConExito = $sentencia->execute($parametros);

$numFilasAfectadas = $sentencia->rowCount();
$unaFilaAfectada = ($numFilasAfectadas == 1);
$ningunaFilaAfectada = ($numFilasAfectadas == 0);

$correcto = ($sqlConExito && $unaFilaAfectada);

$datosNoModificados = ($sqlConExito && $ningunaFilaAfectada);