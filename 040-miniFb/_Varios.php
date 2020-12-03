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

function cerrarSesion()
{
    session_unset();
    session_destroy();

    redireccionar("ContenidoPublico1.php");
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