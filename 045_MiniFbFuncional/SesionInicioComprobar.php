<?php

    require_once "_com/_Varios.php";
    require_once "_com/DAO.php";

$usuario = DAO::obtenerUsuarioPorContrasenna($_REQUEST["identificador"], $_REQUEST["contrasenna"]);

if ($usuario != null) { // Identificador existía y contraseña era correcta.
    establecerSesionRam($usuario);

    if (isset($_REQUEST["recordar"])) {
        DAO::establecerSesionCookie($usuario);
    }

    redireccionar("MuroVerGlobal.php");
} else {
    redireccionar("SesionInicioFormulario.php?datosErroneos");
}