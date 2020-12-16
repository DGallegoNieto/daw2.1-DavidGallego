<?php

declare(strict_types=1);

session_start();

function obtenerPdoConexionBD(): PDO
{
    $servidor = "localhost";
    $bd = "MiniFb";
    $identificador = "root";
    $contrasenna = "";
    $opciones = [
        PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
    ];

    try {
        $conexion = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
    } catch (Exception $e) {
        error_log("Error al conectar: " . $e->getMessage()); // El error se vuelca a php_error.log
        exit('Error al conectar'); //something a user can understand
    }

    return $conexion;
}


function obtenerUsuario(string $identificador, string $contrasenna): ?array
{
    // Conectar con BD
    $pdo = obtenerPdoConexionBD();

    //Lanzar consulta
    $sql = "SELECT * FROM Usuario WHERE identificador=? AND contrasenna=?";
    $sentencia = $pdo ->prepare($sql);
    $sentencia->execute([$identificador, $contrasenna]); //Parámetros de la consulta
    $usuario = $sentencia->fetchAll();

    $unaFilaAfectada = ($sentencia->rowCount() == 1);

    if($unaFilaAfectada){
        return ["id" => $usuario[0]["id"], "identificador" => $usuario[0]["identificador"], "contrasenna" => $usuario[0]["contrasenna"],
            "codigoCookie" => $usuario[0]["codigoCookie"], "tipoUsuario" => $usuario[0]["tipoUsuario"], "nombre" => $usuario[0]["nombre"],
            "apellidos" => $usuario[0]["apellidos"]];
    } else {
        return null;
    }

}

function marcarSesionComoIniciada(array $arrayUsuario)
{

    $_SESSION["id"] = $arrayUsuario["id"];
    $_SESSION["identificador"] = $arrayUsuario["identificador"];
    $_SESSION["contrasenna"] = $arrayUsuario["contrasenna"];
    $_SESSION["nombre"] = $arrayUsuario["nombre"];
    $_SESSION["apellidos"] = $arrayUsuario["apellidos"];
    $_SESSION["codigoCookie"] = $arrayUsuario["codigoCookie"];
    $_SESSION["tipoUsuario"] = $arrayUsuario["tipoUsuario"];

}

function haySesionIniciada(): bool
{
    if(isset($_SESSION["id"])){
        return true;
    } else{
        return false;
    }
}

function generarCookieRecordar(array $arrayUsuario)
{
    $pdo = obtenerPdoConexionBD();

    $codigoCookie = generarCadenaAleatoria(32);

    setcookie("codigoCookie", $codigoCookie, time()+60*60*24);
    setcookie("identificadorCookie", $arrayUsuario["identificador"], time()+60*60*24);

    $sql = "UPDATE Usuario SET codigoCookie=? WHERE id=?";
    $sentencia = $pdo ->prepare($sql);
    $sentencia->execute([$codigoCookie, $arrayUsuario["id"]]); //Parámetros de la consulta


    // TODO Para una seguridad óptima convendría anotar en la BD la fecha de caducidad de la cookie y no aceptar ninguna cookie pasada dicha fecha.
    // TODO Enviamos al cliente, en forma de cookies, el identificador y el codigoCookie: setcookie(...) ...
}

function borrarCookieRecordar()
{
    //TODO borrar cookie BD
    setcookie("codigoCookie", "", time()-60*60*24);
    setcookie("identificadorCookie", "", time()-60*60*24);

}

function hayCookieValida()
{
    if(isset($_COOKIE["codigoCookie"])){
        return true;
    } else {
        return false;
    }
}

function intentarCanjearSesionCookie(): bool
{
    // TODO ¿Ha venido un registro? (Igual que el inicio de sesión)
    //     · Entonces, se la canjeamos por una SESIÓN RAM INICIADA: marcarSesionComoIniciada($arrayUsuario)
    //     · Además, RENOVAMOS (re-creamos) la cookie.


    if(isset($_COOKIE["codigoCookie"]) && isset($_COOKIE["identificadorCookie"])){

        $pdo = obtenerPdoConexionBD();

        $sql = "SELECT * FROM Usuario WHERE identificador=? AND codigoCookie=?";
        $sentencia = $pdo ->prepare($sql);
        $sentencia->execute([$_COOKIE["identificadorCookie"], $_COOKIE["codigoCookie"]]); //Parámetros de la consulta
        $usuario = $sentencia->fetchAll();

        $unaFilaAfectada = ($sentencia->rowCount() == 1);

        if($unaFilaAfectada){
            $_SESSION["id"] = $usuario[0]["id"];
            $_SESSION["identificador"] = $usuario[0]["identificador"];
            $_SESSION["contrasenna"] = $usuario[0]["contrasenna"];
            $_SESSION["nombre"] = $usuario[0]["nombre"];
            $_SESSION["apellidos"] = $usuario[0]["apellidos"];
            $_SESSION["codigoCookie"] = $usuario[0]["codigoCookie"];
            $_SESSION["tipoUsuario"] = $usuario[0]["tipoUsuario"];
            return true;
        } else {
            return false;
        }
    } else {
        borrarCookieRecordar();
        return false;
    }
}

function mostrarInfoUsuario()
{
    if(haySesionIniciada()){
        echo "<span><p>Bienvenido, <a href='UsuarioFicha.php'>$_SESSION[nombre] $_SESSION[apellidos]</a>.</p><a href='SesionCerrar.php'>Cerrar sesión</a></span>";
    } else{
        echo "<span><a href='SesionInicioMostrarFormulario.php'>Iniciar sesión</a></span>";
    }

}

function cerrarSesion()
{
    session_unset();
    session_destroy();

}

function generarCadenaAleatoria(int $longitud): string
{
    for ($s = '', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')-1; $i != $longitud; $x = rand(0,$z), $s .= $a[$x], $i++);
    return $s;
}

// (Esta función no se utiliza en este proyecto pero se deja por si se optimizase el flujo de navegación.)
// Esta función redirige a otra página y deja de ejecutar el PHP que la llamó:
function redireccionar(string $url)
{
    header("Location: $url");
    exit;
}

function syso(string $contenido)
{
    file_put_contents('php://stderr', $contenido . "\n");
}