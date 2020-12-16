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


//Comprobación de si existe un usuario con el mismo identificador y no es un usuario ya registrado que quiera editar su información

$sqlIdentificador = "SELECT * FROM Usuario WHERE identificador=?";
$consultaIdentificador = $pdo->prepare($sqlIdentificador);
$consultaIdentificador ->execute([$identificador]); //parámetros que se envían a la consulta

$numFilasAfectadasIdentificador = $consultaIdentificador->rowCount();

if($numFilasAfectadasIdentificador != 0 && $_REQUEST["identificador"] != $_SESSION["identificador"] || empty($_REQUEST["identificador"])){
    redireccionar("UsuarioFicha.php?errorIdentificador");
} else {
    $identificadorCorrecto = true;
}



//Comprobación de contraseña si viene vacía
if(empty($_REQUEST["contrasenna"])){
    $contrasennaCorrecta = false;
    redireccionar("UsuarioFicha.php?errorContrasenna");
}


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

if($correcto && $identificadorCorrecto){
    redireccionar("ContenidoPrivado1.php");
} else {
    //TODO tratar errores
}
?>
