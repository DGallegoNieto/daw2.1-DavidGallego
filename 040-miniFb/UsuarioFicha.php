<?php

    require_once "_Varios.php";

    //Si existe la sesión, es decir, si el usuario quiere modificar la información
    if(isset($_SESSION["id"])){
        $identificador = $_SESSION["identificador"];
        $contrasenna = $_SESSION["contrasenna"];
        $nombre = $_SESSION["nombre"];
        $apellidos = $_SESSION["apellidos"];
    } else {
        $identificador = "";
        $contrasenna = "";
        $nombre = "";
        $apellidos = "";
    }

?>

<html>
<?php
    if(isset($_SESSION["id"])){
        echo "<h1>Editar información de usuario</h1>";
    } else {
        echo "<h1>Registrar usuario</h1>";
    }
?>

<form action="SesionRegistroGuardar.php">
    <label>Identificador: </label><input type="text" name="identificador" value="<?=$identificador?>">
    <br />
    <label>Contraseña:</label><input type="text" name="contrasenna" value="<?=$contrasenna?>">
    <br />
    <br />
    <label>Nombre: </label><input type="text" name="nombre" value="<?=$nombre?>">
    <br />
    <label>Apellidos: </label><input type="text" name="apellidos" value="<?=$apellidos?>">
    <br />
    <input type="submit" value="Guardar">
</form>


</html>
