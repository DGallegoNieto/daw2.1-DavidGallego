<?php

    require_once "_com/_Varios.php";

    // Comprobamos si hay sesión-usuario iniciada.
    //   - Si la hay, no intervenimos. Dejamos que la pág se cargue.
    //     (Mostrar info del usuario logueado y tal...)
    //   - Si NO la hay, redirigimos a SesionInicioFormulario.php

    if (!haySesionRamIniciada() && !intentarCanjearSesionCookie()) {
        redireccionar("SesionInicioFormulario.php");
    }

    if(isset($_REQUEST["id"])){
        $id = $_REQUEST["id"];
        $_SESSION["destinatarioId"] = $id;
    }

    if(isset($_REQUEST["exito"])){
    }


    $usuario = DAO::obtenerUsuarioPorId($id);
    $publicacionesUsuario = DAO::obtenerPublicacionesUsuario($usuario);
    $publicacionesRecibidas = DAO::obtenerPublicacionesRecibidas($usuario);

    if($id == $_SESSION["id"]){
        $perfilPropio = true;
    } else {
        $perfilPropio = false;
    }
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php pintarInfoSesion(); ?>

<h1>Muro de <?= $usuario->getNombre() . " " . $usuario->getApellidos()?></h1>

<?php if(isset($_REQUEST["exito"])) { ?>
    <p style='color: #00ff00;'>Los datos se han actualizado con éxito.</p>
<?php } ?>

<?php if(isset($_REQUEST["errorEliminar"])) { ?>
    <p style='color: #ff0000;'>Lo sentimos, no se ha podido eliminar la publicación. Inténtelo de nuevo.</p>
<?php } ?>

<?php if($perfilPropio){ ?>
    <h3>Publicar para mí</h3>
    <form action="PublicacionNuevaCrear.php?muroPersonal" method="post">
        <label for="asunto">Asunto</label>
        <input type="text" name="asunto" placeholder="Escriba aquí su asunto"><br><br>

        <p>Contenido</p>
        <textarea rows="4" cols="50" name="contenido" placeholder="Escriba aquí su mensaje"></textarea><br><br>

        <input type="submit" value="Publicar">
    </form>
<?php } else { ?>
    <h3>Publicar para <?= $usuario->getNombre() . " " . $usuario->getApellidos()?></h3>
    <form action="PublicacionNuevaCrear.php?muroOtraPersona" method="post">
        <label for="asunto">Asunto</label>
        <input type="text" name="asunto" placeholder="Escriba aquí su asunto"><br><br>

        <p>Contenido</p>
        <textarea rows="4" cols="50" name="contenido" placeholder="Escriba aquí su mensaje"></textarea><br><br>

        <input type="submit" value="Publicar">
    </form>
<?php } ?>








<?php if($perfilPropio){ ?>
    <h3>Mis publicaciones</h3>
    <table border="1">
        <tr>
            <th>Eliminar</th>
            <th>Fecha</th>
            <th>Emisor</th>
            <th>Asunto</th>
            <th>Contenido</th>
        </tr>
        <?php foreach ($publicacionesUsuario as $publicacionUsuario) { ?>
            <tr>
                <td><a href="PublicacionEliminar.php?id=<?=$publicacionUsuario->getId()?>">(X)</a></td>
                <td> <?=$publicacionUsuario->getFecha()?> </td>
                <td><a href="MuroVerDe.php?id=<?=$publicacionUsuario->getEmisorId()?>"> <?=$usuario->getNombre() . " " . $usuario->getApellidos()?> </a></td>
                <td> <?=$publicacionUsuario->getAsunto()?> </td>
                <td> <?=$publicacionUsuario->getContenido()?> </td>
            </tr>
        <?php } ?>
    </table>

    <h3>Publicaciones recibidas</h3>
    <table border="1">
        <tr>
            <th>Eliminar</th>
            <th>Fecha</th>
            <th>Emisor</th>
            <th>Asunto</th>
            <th>Contenido</th>
        </tr>
        <?php foreach ($publicacionesRecibidas as $publicacionRecibida) {
            $usuarioEmisor = DAO::obtenerUsuarioPorId($publicacionRecibida->getEmisorId());
            ?>
            <tr>
                <td><a href="PublicacionEliminar.php?id=<?=$publicacionRecibida->getId()?>">(X)</a></td>
                <td> <?=$publicacionRecibida->getFecha()?> </td>
                <td><a href="MuroVerDe.php?id=<?=$publicacionRecibida->getEmisorId()?>"> <?=$usuarioEmisor->getNombre() . " " . $usuarioEmisor->getApellidos()?> </a></td>
                <td> <?=$publicacionRecibida->getAsunto()?> </td>
                <td> <?=$publicacionRecibida->getContenido()?> </td>
            </tr>
        <?php } ?>
    </table>
<?php } else { ?>
    <h3>Publicaciones de <?= $usuario->getNombre() . " " . $usuario->getApellidos()?></h3>
    <table border="1">
        <tr>
            <th>Fecha</th>
            <th>Emisor</th>
            <th>Asunto</th>
            <th>Contenido</th>
        </tr>
        <?php foreach ($publicacionesUsuario as $publicacionUsuario) { ?>
            <tr>
                <td> <?=$publicacionUsuario->getFecha()?> </td>
                <td><a href="MuroVerDe.php?id=<?=$publicacionUsuario->getEmisorId()?>"> <?=$usuario->getNombre() . " " . $usuario->getApellidos()?> </a></td>
                <td> <?=$publicacionUsuario->getAsunto()?> </td>
                <td> <?=$publicacionUsuario->getContenido()?> </td>
            </tr>
        <?php } ?>
    </table>
<?php }?>

<br>

<a href='Index.php'>Ir al Inicio</a>

<a href='MuroVerGlobal.php'>Ir al Muro Global</a>



</body>

</html>