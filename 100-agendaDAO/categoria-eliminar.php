<?php
	require_once "_com/_varios.php";
	require_once "_com/dao.php";


	// Se recoge el parámetro "id" de la request.
	$id = (int)$_REQUEST["id"];

    $sqlConExito = DAO::categoriaEliminarPorId($id);

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