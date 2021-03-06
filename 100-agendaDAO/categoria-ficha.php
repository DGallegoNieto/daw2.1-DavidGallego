<?php
	require_once "_com/_varios.php";
	require_once "_com/dao.php";
	
	// Se recoge el parámetro "id" de la request.
	$id = (int)$_REQUEST["id"];

	// Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
	// Sin embargo, si id NO es -1 quieren VER la ficha de una categoría existente
	// (y $nueva_entrada tomará false).
	$nueva_entrada = ($id == -1);

	if ($nueva_entrada) { // Quieren CREAR una nueva entrada, así que no se cargan datos.
		$categoria_nombre = "<introduzca nombre>";
	} else { // Quieren VER la ficha de una categoría existente, cuyos datos se cargan.
        $categoria = DAO::categoriaObtenerPorId($id);

	}
?>



<html>

<head>
	<meta charset="UTF-8">
</head>



<body>

<?php if ($nueva_entrada) { ?>
	<h1>Nueva ficha de categoría</h1>
<?php } else { ?>
	<h1>Ficha de categoría</h1>
<?php } ?>

<form method="post" action="categoria-guardar.php">

<input type="hidden" name="id" value="<?=$id?>" />

<ul>
	<li>
		<strong>Nombre: </strong>
		<input type="text" name="nombre" value="<?=$categoria->getNombre()?>" />
	</li>
</ul>

<?php if ($nueva_entrada) { ?>
	<input type="submit" name="crear" value="Crear categoría" />
<?php } else { ?>
	<input type="submit" name="guardar" value="Guardar cambios" />
<?php } ?>

</form>

<br />

<a href="categoria-eliminar.php?id=<?=$id ?>">Eliminar categoría</a>

<br />
<br />

<a href="categoria-listado.php">Volver al listado de categorías.</a>

</body>

</html>