<?php

require_once "_Varios.php";

$pdo = obtenerPdoConexionBD();

//TODO controlar identificadores repetidos UsuarioFicha.php
//TODO controlar campos vacíos al crear usuarios
//TODO cambiar $_REQUEST por $_SESSION

$identificador = $_REQUEST["identificador"];
$contrasenna = $_REQUEST["contrasenna"];
$nombre = $_REQUEST["nombre"];
$apellidos = $_REQUEST["apellidos"];

//Si no existe sesión, es decir, se quiere crear un usuario
if(!isset($_SESSION["id"])){
    $sql = "INSERT INTO Usuario (identificador, contrasenna, codigoCookie, tipoUsuario, nombre, apellidos) VALUES (?, ?, ?, ?, ?, ?)";
    $parametros = [$identificador, $contrasenna, null, 0, $nombre, $apellidos];
} else {
    $id = $_SESSION["id"]; //TODO esto da fallo, arreglalo con las sesiones
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

if($correcto){
    redireccionar("ContenidoPrivado1.php");
} else {
    //TODO tratar errores
}
?>
