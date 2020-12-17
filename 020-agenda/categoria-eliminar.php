<?php
	require_once "_varios.php";
	require_once "dao.php";

	$pdo = obtenerPdoConexionBD();

	// Se recoge el parámetro "id" de la request.
	$id = (int)$_REQUEST["id"];

    $sqlConExito = DAO::ejecutarActualizacion("DELETE FROM categoria WHERE id=?", [$id]);

?>



<html>

<head>
	<meta charset="UTF-8">
</head>


<body>

<?php if ($sqlConExito) { ?>

	<h1>Eliminación completada</h1>
	<p>Se ha eliminado correctamente la categoría.</p>

<?php } else { ?>

	<h1>Error en la eliminación</h1>
	<p>No se ha podido eliminar la categoría o la categoría no existía.</p>

<?php } ?>

<a href="categoria-listado.php">Volver al listado de categorías.</a>

</body>

</html>