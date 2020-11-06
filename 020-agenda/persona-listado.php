<?php
    require_once "_varios.php";

    $pdo = obtenerPdoConexionBD();

	$sql = "SELECT
                p.id     AS pId,
                p.nombre AS pNombre,
                p.apellidos AS pApellidos,
                p.categoriaId AS pCategoriaId,
                c.id     AS cId,
                c.nombre AS cNombre
            FROM
               persona AS p INNER JOIN categoria AS c
               ON p.categoriaId = c.id
            ORDER BY p.nombre
    ";
    $select = $pdo->prepare($sql);
    $select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
    $rs = $select->fetchAll();

    //$estrella = false;

?>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
<h1>Listado de personas</h1>

<table border="1">

    <tr>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Categoría</th>
    </tr>
    <?php
    foreach ($rs as $fila) { ?>
        <tr>
            <td><a href="persona-ficha.php?id=<?=$fila["pId"]?>"> <?=$fila["pNombre"] ?></a>
                <?php //if($estrella) { ?><img src="imgEstrella.png" width="12" height="12">?></td>
            <td><a href="persona-ficha.php?id=<?=$fila["pId"]?>"> <?=$fila["pApellidos"] ?> </a></td>
            <td><a href="categoria-ficha.php?id=<?=$fila["cId"]?>"> <?=$fila["cNombre"] ?> </a></td>
            <td><a href="persona-eliminar.php?id=<?=$fila["pId"]?>"> (X) </a></td>
        </tr>
    <?php } ?>

</table>

<br />

<a href="persona-ficha.php?id=-1">Crear entrada</a>

<br />
<br />

<a href="categoria-listado.php">Gestionar listado de categorías</a>

</body>

</html>
