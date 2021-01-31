<?php

require_once "_com/_Varios.php";
require_once "_com/DAO.php";

if(isset($_REQUEST["id"])){
    $publicacionId = $_REQUEST["id"];
}

$correcto = DAO::eliminarPublicacion($publicacionId);

if($correcto == 1){
    redireccionar("MuroVerDe.php?id=" . $_SESSION["id"]);
} else {
    redireccionar("MuroVerDe.php?id=" . $_SESSION["id"] . "&errorEliminar");
}
