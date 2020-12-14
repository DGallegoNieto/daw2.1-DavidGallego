<?php

require_once "_Varios.php";

$pdo = obtenerPdoConexionBD();

$identificador = (string)$_REQUEST["identificador"];
$contrasenna= (string)$_REQUEST["contrasenna"];

$arrayUsuario = obtenerUsuario($identificador, $contrasenna);


if ($arrayUsuario["contrasenna"] == $contrasenna) { // HAN venido datos: identificador existía y contraseña era correcta.

    if(isset($_REQUEST["recordar"])){
        generarCookieRecordar($arrayUsuario);
    }

    marcarSesionComoIniciada($arrayUsuario);
    redireccionar("ContenidoPrivado1.php");

} else {
    //Redirigir.

    redireccionar("SesionInicioMostrarFormulario.php?error");
}
