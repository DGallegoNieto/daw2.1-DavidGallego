<?php

require_once "_com/_Varios.php";
require_once "_com/DAO.php";


$id = $_SESSION["id"];
$identificador = $_REQUEST["identificador"];
$nombre = $_REQUEST["nombre"];
$apellidos = $_REQUEST["apellidos"];

$contrasennaNueva = $_REQUEST["contrasennaNueva"];
$contrasennaNueva2 = $_REQUEST["contrasennaNueva2"];


//Si el identificador que recibe existe en la base de datos y es diferente del de la sesión
if(DAO::buscaUsuarioIdentificador($identificador) == 1 && $identificador != $_SESSION["identificador"]){
    redireccionar("UsuarioPerfilVer.php?identificadorErroneo");
}

//Si las contraseñas no coinciden
if($contrasennaNueva != $contrasennaNueva2){
    redireccionar("UsuarioPerfilVer.php?contrasennaErronea");
}

$correcto = DAO::actualizarUsuarioEnBd($id, $identificador, $nombre, $apellidos, $contrasennaNueva);

if($correcto){
    redireccionar("MuroVerDe.php?id=" . $id . "&&exito");
} else {
    redireccionar("UsuarioPerfilVer.php?error");
}


