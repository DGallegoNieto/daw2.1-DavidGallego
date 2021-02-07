<?php

require_once "clases.php";

class DAO{

private static $pdo = null;

private static function obtenerPdoConexionBD()
{
    $servidor = "localhost";
    $identificador = "root";
    $contrasenna = "";
    $bd = "agenda"; // Schema
    $opciones = [
        PDO::ATTR_EMULATE_PREPARES => false, // Modo emulación desactivado para prepared statements "reales"
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Que los errores salgan como excepciones.
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // El modo de fetch que queremos por defecto.
    ];

    try {
        $pdo = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
    } catch (Exception $e) {
        error_log("Error al conectar: " . $e->getMessage());
        exit("Error al conectar" . $e->getMessage());
    }

    return $pdo;
}

private static function ejecutarConsulta(string $sql, array $parametros): array
{
    if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

    $select = self::$pdo->prepare($sql);
    $select->execute($parametros);
    return $select->fetchAll();
}

public static function ejecutarActualizacion(string $sql, array $parametros): bool
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $actualizacion = self::$pdo->prepare($sql);
        $sqlConExito = $actualizacion->execute($parametros);

        $unaFilaAfectada = ($actualizacion->rowCount() == 1);

        $correcto = ($sqlConExito && $unaFilaAfectada);

        return $correcto;
    }

public static function categoriaObtenerTodas(): array
{
    $datos = [];
    $rs = self::ejecutarConsulta("SELECT * FROM categoria ORDER BY nombre", []);

    foreach ($rs as $fila) {
        $categoria = new Categoria($fila["id"], $fila["nombre"]);
        array_push($datos, $categoria);
    }
    return $datos;
}



public static function agregarCategoria($nombre)
{
    self::ejecutarActualizacion("INSERT INTO categoria (nombre) VALUES (?);", [$nombre]);
}
}


