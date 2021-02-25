<?php

require_once "_com/DAO.php";

$id = $_REQUEST["id"];
$nombre = $_REQUEST["nombre"];
$apellidos = $_REQUEST["apellidos"];
$telefono = $_REQUEST["telefono"];
$categoriaId = $_REQUEST["categoriaId"];

$persona = DAO::personaModificar($id, $nombre, $apellidos, $telefono, $categoriaId);

echo json_encode($persona);