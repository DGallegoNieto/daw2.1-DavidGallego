<?php
    require_once "_Varios.php";

    borrarCookieRecordar($_SESSION["id"]);

    cerrarSesion();
    redireccionar("ContenidoPublico1.php");

?>
