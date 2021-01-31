<?php

    require_once "_com/_Varios.php";
    require_once "_com/DAO.php";

    $asunto = $_REQUEST["asunto"];
    $contenido = $_REQUEST["contenido"];

    if(isset($_SESSION["id"])){
        $emisorId = $_SESSION["id"];
    }

    if(isset($_SESSION["destinatarioId"])){
        $destinatarioId = $_SESSION["destinatarioId"];
    }


    $muroGlobal = isset($_REQUEST["muroGlobal"]);

    $muroPersonal = isset($_REQUEST["muroPersonal"]);

    $muroOtraPersona = isset($_REQUEST["muroOtraPersona"]);


    if($muroGlobal){
        if(DAO::crearPublicacion($emisorId, NULL, $asunto, $contenido) == 1){
            redireccionar("MuroVerGlobal.php");
        } else {
            redireccionar("MuroVerGlobal.php?errorPublicacion");
        }
    } else if($muroPersonal){
        if(DAO::crearPublicacion($emisorId, $destinatarioId, $asunto, $contenido) == 1){
            redireccionar("MuroVerDe.php?id=". $emisorId);
        } else {
            redireccionar("MuroVerDe.php?id=". $emisorId ."&errorPublicacion");
        }
    } else if($muroOtraPersona){
        if(DAO::crearPublicacion($emisorId, $destinatarioId, $asunto, $contenido) == 1){
            redireccionar("MuroVerDe.php?id=". $destinatarioId);
        } else{
            redireccionar("MuroVerDe.php?id=". $destinatarioId ."&errorPublicacion");
        }
    } else{
        echo "asd";
    }

?>