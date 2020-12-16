<?php
	require_once "_varios.php";
	require_once  "dao.php";

    $categorias = DAO::categoriaObtenerTodas();
?>



<html>

<head>
	<meta charset="UTF-8">
</head>



<body>

<h1>Listado de Categorías</h1>

<table border="1">

	<tr>
		<th>Nombre</th>
	</tr>

	<?php
        foreach ($categorias as $fila) { ?>
			<tr>
				<td><a href="categoria-ficha.php?id=<?=$fila["id"]?>"> <?=$fila["nombre"] ?> </a></td>
				<td><a href="categoria-eliminar.php?id=<?=$fila["id"]?>"> (X) </a></td>
			</tr>
	<?php } ?>

</table>

<br />

<a href="categoria-ficha.php?id=-1">Crear entrada</a>

<br />
<br />

<a href="persona-listado.php">Gestionar listado de Personas</a>

</body>

</html>