<?php

abstract class Dato
{
}

trait Identificable
{
    protected int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}

class Categoria extends Dato implements JsonSerializable
{
    use Identificable;

    private string $nombre;
    private array $personasPertenecientes;

    public function __construct(int $id, string $nombre)
    {
        $this->setId($id);
        $this->setNombre($nombre);
    }

    public function jsonSerialize()
    {
        return [
            "nombre" => $this->nombre,
            "id" => $this->id,
        ];

    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function obtenerPersonasPertenecientes(): array
    {
        if ($this->personasPertenecientes == null) $personasPertenecientes = DAO::personaObtenerPorCategoria($this->id);

        return $personasPertenecientes;
    }
}

class Persona extends Dato implements JsonSerializable
{
    use Identificable;

    private $nombre;
    private $apellidos;
    private $telefono;
    private $estrella;
    private $categoriaId;

    public function __construct(int $id, string $nombre, string $apellidos, string $telefono, string $estrella, string $categoriaId)
    {
        self::setId($id);
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->telefono = $telefono;
        $this->estrella = $estrella;
        $this->categoriaId = $categoriaId;
    }

    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "nombre" => $this->nombre,
            "apellidos" => $this->apellidos,
            "telefono" => $this->telefono,
            "estrella" => $this->estrella,
            "categoriaId" => $this->categoriaId,
        ];

        // Esto sería lo mismo:
        //$array["nombre"] = $this->nombre;
        //$array["id"] = $this->id;
        //return $array;
    }


    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }


    public function setApellidos(string $apellidos)
    {
        $this->apellidos = $apellidos;
    }


    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono)
    {
        $this->telefono = $telefono;
    }

    public function getEstrella(): string
    {
        return $this->estrella;
    }


    public function setEstrella(string $estrella)
    {
        $this->estrella = $estrella;
    }


    public function getCategoriaId(): string
    {
        return $this->categoriaId;
    }

    public function setCategoriaId(string $categoriaId)
    {
        $this->categoriaId = $categoriaId;
    }




}