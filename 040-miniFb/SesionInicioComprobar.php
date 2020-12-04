<?php

require_once "_Varios.php";

$pdo = obtenerPdoConexionBD();

$identificador = (string)$_REQUEST["identificador"];
$contrasenna= (string)$_REQUEST["contrasenna"];

$arrayUsuario = obtenerUsuario($identificador, $contrasenna);


if ($arrayUsuario["contrasenna"] == $contrasenna) { // HAN venido datos: identificador existía y contraseña era correcta.
    //TODO crear cookie si viene checkbox recuérdame
    marcarSesionComoIniciada($arrayUsuario);
    redireccionar("ContenidoPrivado1.php");

} else {
    //Redirigir.

    redireccionar("SesionInicioMostrarFormulario.php?error");
}
