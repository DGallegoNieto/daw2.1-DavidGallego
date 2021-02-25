<?php
require_once "_com/DAO.php";

$id = $_REQUEST["id"];

$persona = DAO::personaEliminarPorId($id);

//echo $categoria;
?>