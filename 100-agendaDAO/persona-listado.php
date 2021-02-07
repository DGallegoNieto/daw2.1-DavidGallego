<?php
    require_once "_com/_varios.php";
    require_once "_com/dao.php";

    $personas = DAO::personaObtenerTodas();
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
    foreach ($personas as $persona) {
        $categoria = DAO::categoriaObtenerPorId($persona->getCategoriaId());
        ?>
        <tr>
            <td><a href="persona-ficha.php?id=<?=$persona->getId()?>"> <?=$persona->getNombre() ?></a>
                <?php //if($estrella) { ?><img src="imgEstrella.png" width="12" height="12"></td>
            <td><a href="persona-ficha.php?id=<?=$persona->getId()?>"> <?=$persona->getApellidos() ?> </a></td>
            <td><a href="categoria-ficha.php?id=<$persona->getId()?>"> <?=$categoria->getNombre() ?> </a></td>
            <td><a href="persona-eliminar.php?id=<?=$persona->getId()?>"> (X) </a></td>
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
