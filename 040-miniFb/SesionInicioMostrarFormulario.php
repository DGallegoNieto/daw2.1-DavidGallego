<?php
    session_start();
?>

<html>

<head>
    <meta charset='UTF-8'>
</head>

<body>

<h1>Iniciar Sesión</h1>

<?php
    //Muestra en caso de que la contraseña no coincida con la de la base de datos
    if(isset($_SESSION["error"])){
        echo "<h2>$_SESSION[error]</h2>";
    }

?>
<form action='SesionInicioComprobar.php' method='get'>
    <label>Usuario: </label><input type="text" name="identificador" >
    <br />
    <label>Contraseña: </label><input type="text" name="contrasenna">
    <br />
    <input type="submit" value="Confirmar">
</form>


</body>

</html>