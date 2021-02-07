<?php
require_once "_com/_varios.php";
require_once "_com/dao.php";


    // Se recoge el parámetro "id" de la request.
    $id = (int)$_REQUEST["id"];

    $correcto = DAO::personaEliminarPorId($id);
?>

<html>

<head>
    <meta charset="UTF-8">
</head>


<body>

<?php if ($correcto) { ?>

    <h1>Eliminación completada</h1>
    <p>Se ha eliminado correctamente el contacto.</p>

<?php } else { ?>

    <h1>Error en la eliminación</h1>
    <p>No se ha podido eliminar el contacto o el contacto no existía.</p>

<?php } ?>

<a href="persona-listado.php">Volver al listado de personas.</a>

</body>

</html>