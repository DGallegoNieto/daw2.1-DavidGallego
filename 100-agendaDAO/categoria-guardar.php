<?php
    require_once "_com/_varios.php";
    require_once "_com/dao.php";

	$pdo = obtenerPdoConexionBD();

	// Se recogen los datos del formulario de la request.
	$id = (int)$_REQUEST["id"];
	$nombre = $_REQUEST["nombre"];

	// Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
	// Sin embargo, si id NO es -1 quieren VER la ficha de una categoría existente
	// (y $nueva_entrada tomará false).
	$nueva_entrada = ($id == -1);
	
	if ($nueva_entrada) {
		// Quieren CREAR una nueva entrada, así que es un INSERT.
        $correcto = DAO::ejecutarActualizacion("INSERT INTO categoria (nombre) VALUES (?)", [$nombre]);

	} else {
		// Quieren MODIFICAR una categoría existente y es un UPDATE.
        $correcto = DAO::ejecutarActualizacion("UPDATE categoria SET nombre=? WHERE id=?", [$nombre, $id]);

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
	<p>No se han podido guardar los datos de la categoría.</p>

<?php
	}
?>

<a href="categoria-listado.php">Volver al listado de categorías.</a>

</body>

</html>