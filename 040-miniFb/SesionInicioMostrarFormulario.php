<?php
    session_start();

    $error = isset($_REQUEST["error"]);

?>

<html>

<head>
    <meta charset='UTF-8'>
</head>

<body>

<h1>Iniciar Sesión</h1>

<?php
    //Muestra en caso de que la contraseña no coincida con la de la base de datos
    if($error){
        echo "<h2>La contraseña no es correcta.</h2>";
    }


?>
<form action='SesionInicioComprobar.php' method='get'>
    <label for="identificador">Usuario: </label><input type="text" name="identificador" >
    <br />
    <label for="contrasenna">Contraseña: </label><input type="text" name="contrasenna">
    <br />
    <label for="recordar">Recuérdame: </label><input type="checkbox" name="recordar">
    <br />
    <input type="submit" value="Confirmar">
    <br />
    <a href='UsuarioFicha.php'>¿No tienes cuenta? ¡Regístrate!</a>
</form>


</body>

</html>