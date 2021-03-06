<?php
require_once "_varios.php";

$pdo = obtenerPdoConexionBD();

// Se recoge el parámetro "id" de la request.
$id = (int)$_REQUEST["id"];

// Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
// Sin embargo, si id NO es -1 quieren VER la ficha de una categoría existente
// (y $nueva_entrada tomará false).
$nuevaEntrada = ($id == -1);

if ($nuevaEntrada) { // Quieren CREAR una nueva entrada, así que no se cargan datos.
    $personaNombre = "<introduzca nombre>";
    $personaApellidos = "<introduzca apellidos>";
    $personaTelefono="<introduzca telefono>";
    $personaCategoriaId= 0;
} else { // Quieren VER la ficha de una categoría existente, cuyos datos se cargan.
    $sql = "SELECT nombre, apellidos, telefono, categoriaId FROM persona WHERE id=?";

    $select = $pdo->prepare($sql);
    $select->execute([$id]); // Se añade el parámetro a la consulta preparada.
    $rs = $select->fetchAll();

    // Con esto, accedemos a los datos de la primera (y esperemos que única) fila que haya venido.
    $personaNombre = $rs[0]["nombre"];
    $personaApellidos = $rs[0]["apellidos"];
    $personaTelefono = $rs[0]["telefono"];
    $personaCategoriaId = $rs[0]["categoriaId"];

    //Preparar select de categorias
    $sqlCategorias = "SELECT id, nombre FROM categoria ORDER BY nombre";

    $select = $pdo->prepare($sqlCategorias);
    $select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
    $rsCategorias = $select->fetchAll();
}
?>



<html>

<head>
    <meta charset="UTF-8">
</head>



<body>

<?php if ($nuevaEntrada) { ?>
    <h1>Nueva ficha de persona</h1>
<?php } else { ?>
    <h1>Ficha de persona</h1>
<?php } ?>

<form method="post" action="persona-guardar.php">

    <input type="hidden" name="id" value="<?=$id?>" />

    <ul>
        <!--<li>
            <strong>Favoritos: </strong>
            <input type="radio" name="estrella" value="" />
        </li>-->
        <li>
            <strong>Nombre: </strong>
            <input type="text" name="nombre" value="<?=$personaNombre?>" />
        </li>
        <li>
            <strong>Apellidos: </strong>
            <input type="text" name="apellidos" value="<?=$personaApellidos?>" />
        </li>
        <li>
            <strong>Teléfono: </strong>
            <input type="text" name="telefono" value="<?=$personaTelefono?>" />
        </li>
        <li>
            <strong>Categoría: </strong>
            <select name='categoriaId'>
            <?php
            foreach ($rsCategorias as $filaCategoria) {
                $categoriaId = (int) $filaCategoria["categoriaId"];
                $categoriaNombre = $filaCategoria["nombre"];

                if ($categoriaId == $personaCategoriaId) $seleccion = "selected='true'";
                else                                     $seleccion = "";

                echo "<option value='$categoriaId' $seleccion>$categoriaNombre</option>";

                // Alternativa (peor):
                // if ($categoriaId == $personaCategoriaId) echo "<option value='$categoriaId' selected='true'>$categoriaNombre</option>";
                // else                                     echo "<option value='$categoriaId'                >$categoriaNombre</option>";
            }
            ?>
            </select>
        </li>
    </ul>

    <?php if ($nuevaEntrada) { ?>
        <input type="submit" name="crear" value="Crear contacto" />
    <?php } else { ?>
        <input type="submit" name="guardar" value="Guardar cambios" />
    <?php } ?>

</form>

<br />

<a href="persona-eliminar.php?id=<?=$id ?>">Eliminar contacto</a>

<br />
<br />

<a href="persona-listado.php">Volver al listado de personas.</a>

</body>

</html>