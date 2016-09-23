<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empleados
 *
 * @ORM\Table(name="empleados", uniqueConstraints={@ORM\UniqueConstraint(name="empleados_pk", columns={"id_empleado"})})
 * @ORM\Entity
 */
class Empleados
{
    /**
     * @var string
     *
     * @ORM\Column(name="id_empleado", type="string", length=13, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="empleados_id_empleado_seq", allocationSize=1, initialValue=1)
     */
    private $idEmpleado;

    /**
     * @var integer
     *
     * @ORM\Column(name="dui", type="integer", nullable=true)
     */
    private $dui;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_completo", type="string", length=100, nullable=true)
     */
    private $nombreCompleto;

    /**
     * @var string
     *
     * @ORM\Column(name="primer_apellido", type="string", length=30, nullable=true)
     */
    private $primerApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="srgundo_apellido", type="string", length=30, nullable=true)
     */
    private $srgundoApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido_casada", type="string", length=30, nullable=true)
     */
    private $apellidoCasada;

    /**
     * @var string
     *
     * @ORM\Column(name="primer_nombre", type="string", length=30, nullable=true)
     */
    private $primerNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="segundo_nombre", type="string", length=30, nullable=true)
     */
    private $segundoNombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="activo", type="integer", nullable=true)
     */
    private $activo;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo_empleado", type="integer", nullable=true)
     */
    private $tipoEmpleado;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario", type="string", length=50, nullable=true)
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=200, nullable=true)
     */
    private $password;



    /**
     * Get idEmpleado
     *
     * @return string 
     */
    public function getIdEmpleado()
    {
        return $this->idEmpleado;
    }

    /**
     * Set dui
     *
     * @param integer $dui
     * @return Empleados
     */
    public function setDui($dui)
    {
        $this->dui = $dui;

        return $this;
    }

    /**
     * Get dui
     *
     * @return integer 
     */
    public function getDui()
    {
        return $this->dui;
    }

    /**
     * Set nombreCompleto
     *
     * @param string $nombreCompleto
     * @return Empleados
     */
    public function setNombreCompleto($nombreCompleto)
    {
        $this->nombreCompleto = $nombreCompleto;

        return $this;
    }

    /**
     * Get nombreCompleto
     *
     * @return string 
     */
    public function getNombreCompleto()
    {
        return $this->nombreCompleto;
    }

    /**
     * Set primerApellido
     *
     * @param string $primerApellido
     * @return Empleados
     */
    public function setPrimerApellido($primerApellido)
    {
        $this->primerApellido = $primerApellido;

        return $this;
    }

    /**
     * Get primerApellido
     *
     * @return string 
     */
    public function getPrimerApellido()
    {
        return $this->primerApellido;
    }

    /**
     * Set srgundoApellido
     *
     * @param string $srgundoApellido
     * @return Empleados
     */
    public function setSrgundoApellido($srgundoApellido)
    {
        $this->srgundoApellido = $srgundoApellido;

        return $this;
    }

    /**
     * Get srgundoApellido
     *
     * @return string 
     */
    public function getSrgundoApellido()
    {
        return $this->srgundoApellido;
    }

    /**
     * Set apellidoCasada
     *
     * @param string $apellidoCasada
     * @return Empleados
     */
    public function setApellidoCasada($apellidoCasada)
    {
        $this->apellidoCasada = $apellidoCasada;

        return $this;
    }

    /**
     * Get apellidoCasada
     *
     * @return string 
     */
    public function getApellidoCasada()
    {
        return $this->apellidoCasada;
    }

    /**
     * Set primerNombre
     *
     * @param string $primerNombre
     * @return Empleados
     */
    public function setPrimerNombre($primerNombre)
    {
        $this->primerNombre = $primerNombre;

        return $this;
    }

    /**
     * Get primerNombre
     *
     * @return string 
     */
    public function getPrimerNombre()
    {
        return $this->primerNombre;
    }

    /**
     * Set segundoNombre
     *
     * @param string $segundoNombre
     * @return Empleados
     */
    public function setSegundoNombre($segundoNombre)
    {
        $this->segundoNombre = $segundoNombre;

        return $this;
    }

    /**
     * Get segundoNombre
     *
     * @return string 
     */
    public function getSegundoNombre()
    {
        return $this->segundoNombre;
    }

    /**
     * Set activo
     *
     * @param integer $activo
     * @return Empleados
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return integer 
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set tipoEmpleado
     *
     * @param integer $tipoEmpleado
     * @return Empleados
     */
    public function setTipoEmpleado($tipoEmpleado)
    {
        $this->tipoEmpleado = $tipoEmpleado;

        return $this;
    }

    /**
     * Get tipoEmpleado
     *
     * @return integer 
     */
    public function getTipoEmpleado()
    {
        return $this->tipoEmpleado;
    }

    /**
     * Set usuario
     *
     * @param string $usuario
     * @return Empleados
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return string 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Empleados
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }
}
