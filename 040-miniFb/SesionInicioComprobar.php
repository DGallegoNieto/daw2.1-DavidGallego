<?php

require_once "_Varios.php";

$pdo = obtenerPdoConexionBD();

$identificador = (string)$_REQUEST["identificador"];
$contrasenna= (string)$_REQUEST["contrasenna"];

$arrayUsuario = obtenerUsuario($identificador, $contrasenna);


if ($arrayUsuario["contrasenna"] == $contrasenna) { // HAN venido datos: identificador existía y contraseña era correcta.

    marcarSesionComoIniciada($arrayUsuario);
    redireccionar("ContenidoPrivado1.php");

} else {
    //Redirigir.
    $_SESSION["error"] = "La contraseña no es correcta.";
    redireccionar("SesionInicioMostrarFormulario.php");
}
