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

    /* CATEGORÍA */

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

    private static function crearCategoriaDesdeRs(array $fila): Categoria
    {
        return new Categoria($fila["id"], $fila["nombre"]);
    }


    public static function categoriaObtenerPorId(int $id): ?Categoria
    {

        $rs = self::ejecutarConsulta("SELECT * FROM categoria WHERE id=?", [$id]);

        if ($rs) {
            return self::crearCategoriaDesdeRs($rs[0]);
        } else{
            return null;
        }

    }

    public static function categoriaEliminarPorId(int $id): bool
    {
        return self::ejecutarActualizacion("DELETE FROM categoria WHERE id=?", [$id]);
    }


    public static function categoriaCrear(string $nombre): bool
    {
        return self::ejecutarActualizacion("INSERT INTO categoria (nombre) VALUES (?);", [$nombre]);
    }

    public static function categoriaModificar(int $id, string $nombre): bool
    {
        return self::ejecutarActualizacion("UPDATE categoria SET nombre=? WHERE id=?", [$nombre, $id]);
    }

    /* PERSONA */

    public static function personaObtenerTodas(): array
    {
        $datos = [];
        $rs = self::ejecutarConsulta("SELECT * FROM persona ORDER BY nombre", []);

        foreach ($rs as $fila) {
            $persona = new Persona($fila["id"], $fila["nombre"], $fila["apellidos"], $fila["telefono"], $fila["estrella"], $fila["categoriaId"]);
            array_push($datos, $persona);
        }
        return $datos;
    }

    private static function crearPersonaDesdeRs(array $fila): Persona
    {
        return new Persona($fila["id"], $fila["nombre"], $fila["apellidos"], $fila["telefono"], $fila["estrella"], $fila["categoriaId"]);
    }

    public static function personaObtenerPorId(int $id): ?Persona
    {

        $rs = self::ejecutarConsulta("SELECT * FROM persona WHERE id=?", [$id]);

        if ($rs) {
            return self::crearPersonaDesdeRs($rs[0]);
        } else {
            return null;
        }
    }

    public static function personaEliminarPorId(int $id): bool
    {
        return self::ejecutarActualizacion("DELETE FROM persona WHERE id=?", [$id]);
    }


    public static function personaCrear(string $nombre, string $apellidos, string $telefono, string $estrella, int $categoriaId): bool
    {
        return self::ejecutarActualizacion("INSERT INTO persona (nombre, apellidos, telefono, estrella, categoriaId) VALUES (?, ?, ?, ?, ?);", [$nombre, $apellidos, $telefono, $estrella, $categoriaId]);
    }

    public static function personaModificar(int $id, string $nombre, string $apellidos, string $telefono, string $estrella, int $categoriaId): bool
    {
        return self::ejecutarActualizacion("UPDATE persona SET nombre=?, apellidos=?, telefono=?, estrella=?, categoriaId=? WHERE id=?", [$id, $nombre, $apellidos, $telefono, $estrella, $categoriaId]);
    }

}


