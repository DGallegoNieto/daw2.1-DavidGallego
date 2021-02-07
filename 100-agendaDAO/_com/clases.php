<?php

abstract class Dato
{
}

trait Identificable
{
    protected $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}

class Categoria extends Dato
{
    use Identificable;

    private $nombre;

    function __construct(int $id, string $nombre)
    {
        self::setId($id);
        $this->nombre = $nombre;
    }


    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

}

class Persona extends Dato
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