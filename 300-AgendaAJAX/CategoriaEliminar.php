<?php
    require_once "_com/DAO.php";

    $id = $_REQUEST["id"];

    $categoria = DAO::categoriaEliminarPorId($id);

    redireccionar("Agenda.html");
?>