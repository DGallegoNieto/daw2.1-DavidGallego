<?php
require_once "_com/_varios.php";
require_once "_com/dao.php";

// Se recogen los datos del formulario de la request.
$id = (int)$_REQUEST["id"];
$nombre = $_REQUEST["nombre"];
$apellidos = $_REQUEST["apellidos"];
$telefono = $_REQUEST["telefono"];
$estrella = 0;
$categoriaId = (int)$_REQUEST["categoriaId"];

// Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
// Sin embargo, si id NO es -1 quieren VER la ficha de una persona existente
// (y $nueva_entrada tomará false).
$nueva_entrada = ($id == -1);

if ($nueva_entrada) {
    // Quieren CREAR una nueva entrada, así que es un INSERT.
    $correcto = DAO::personaCrear($nombre, $apellidos, $telefono, $estrella, $categoriaId);
} else {
    // Quieren MODIFICAR una persona existente y es un UPDATE.
    $correcto = DAO::personaModificar($id, $nombre, $apellidos, $telefono, $estrella, $categoriaId);

}

?>



<html>

<head>
    <meta charset="UTF-8">
</head>



<body>

<?php
// Todo bien tanto si se han guardado los datos nuevos como si no se habían modificado.
if ($correcto) { ?>

    <?php if ($id == -1) { ?>
        <h1>Inserción completada</h1>
        <p>Se ha insertado correctamente la nueva entrada de <?php echo $nombre; ?>.</p>
    <?php } else { ?>
        <h1>Guardado completado</h1>
        <p>Se han guardado correctamente los datos de <?php echo $nombre; ?>.</p>
    <?php }
    ?>

    <?php
} else {
    ?>

    <h1>Error en la modificación.</h1>
    <p>No se han podido guardar los datos de el contacto.</p>

    <?php
}
?>

<a href="persona-listado.php">Volver al listado de personas.</a>

</body>

</html>