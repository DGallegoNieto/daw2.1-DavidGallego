<?php
require_once "_com/DAO.php";

$nombre = $_REQUEST["nombre"];
$apellidos = $_REQUEST["apellidos"];
$telefono = $_REQUEST["telefono"];
$categoriaId = $_REQUEST["categoriaId"];

$persona = DAO::personaCrear($nombre, $apellidos, $telefono, $categoriaId);

echo json_encode($persona);
?>