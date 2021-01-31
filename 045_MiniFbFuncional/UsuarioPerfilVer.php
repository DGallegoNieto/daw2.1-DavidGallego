<?php

    require_once "_com/_Varios.php";
    require_once "_com/DAO.php";

    if(!haySesionRamIniciada()){
        redireccionar("Index.php");
    }

    $usuario = DAO::obtenerUsuarioPorId($_SESSION["id"]);

    $identificadorErroneo = isset($_REQUEST["identificadorErroneo"]);

    $contrasennaErronea = isset($_REQUEST["contrasennaErronea"])


?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php pintarInfoSesion(); ?>

<?php if (isset($_REQUEST["error"])) { ?>
    <p style='color: #ff0000;'>Error, no se han podido guardar los cambios. Inténtelo de nuevo.</p>
<?php } ?>

<?php if ($identificadorErroneo) { ?>
    <p style='color: #ff0000;'>Ya existe un usuario con ese identificador. Inténtelo de nuevo.</p>
<?php } ?>

<?php if ($contrasennaErronea) { ?>
    <p style='color: #ff0000;'>Las contraseñas no coinciden. Inténtelo de nuevo.</p>
<?php } ?>

<h1>Perfil de <?= $usuario->getNombre() . " " . $usuario->getApellidos()?></h1>


<form action='UsuarioPerfilGuardar.php' method="post">
    <label for='identificador'>Identificador</label>
    <input type='text' name='identificador' value="<?=$usuario->getIdentificador()?>"><br><br>

    <label for='nombre'>Nombre</label>
    <input type='text' name='nombre' value="<?=$usuario->getNombre()?>"><br><br>

    <label for='apellidos'>Apellidos</label>
    <input type='text' name='apellidos' value="<?=$usuario->getApellidos()?>"><br><br>


    <label for='contrasenna2'>Nueva contraseña</label>
    <input type='password' name='contrasennaNueva' id='contrasennaNueva'><br><br>

    <label for='contrasenna2'>Confirma nueva contraseña</label>
    <input type='password' name='contrasennaNueva2' id='contrasennaNueva2'><br><br>

    <input type='submit' value='Guardar cambios'>
</form>


</body>

</html>