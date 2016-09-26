<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario", uniqueConstraints={@ORM\UniqueConstraint(name="usuario_pk", columns={"id_ui"})}, indexes={@ORM\Index(name="d_fk", columns={"id_empleado"}), @ORM\Index(name="e_fk", columns={"id_rol"})})
 * @ORM\Entity
 */
class Usuario implements AdvancedUserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_ui", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="usuario_id_ui_seq", allocationSize=1, initialValue=1)
     */
    private $idUi;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=40, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=40, nullable=true)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=50, nullable=true)
     */
    private $correo;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=9, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="nomusuario", type="string", length=50, nullable=true)
     */
    private $nomusuario;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=30, nullable=true)
     */
    private $password;

    /**
     * @var integer
     *
     * @ORM\Column(name="isactive", type="integer", nullable=true)
     */
    private $isactive;

    /**
     * @var string
     *
     * @ORM\Column(name="id_empleado", type="string", length=13, nullable=true)
     */
    private $idEmpleado;

    /**
     * @var \Roles
     *
     * @ORM\ManyToOne(targetEntity="Roles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_rol", referencedColumnName="id_rol")
     * })
     */
    private $idRol;



    /**
     * Get idUi
     *
     * @return integer
     */
    public function getIdUi()
    {
        return $this->idUi;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Usuario
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     * @return Usuario
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set correo
     *
     * @param string $correo
     * @return Usuario
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Usuario
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set nomusuario
     *
     * @param string $nomusuario
     * @return Usuario
     */
    public function setNomusuario($nomusuario)
    {
        $this->nomusuario = $nomusuario;

        return $this;
    }

    /**
     * Get nomusuario
     *
     * @return string
     */
    public function getNomusuario()
    {
        return $this->nomusuario;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Usuario
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

    /**
     * Set isactive
     *
     * @param integer $isactive
     * @return Usuario
     */
    public function setIsactive($isactive)
    {
        $this->isactive = $isactive;

        return $this;
    }

    /**
     * Get isactive
     *
     * @return integer
     */
    public function getIsactive()
    {
        return $this->isactive;
    }

    /**
     * Set idEmpleado
     *
     * @param string $idEmpleado
     * @return Usuario
     */
    public function setIdEmpleado($idEmpleado)
    {
        $this->idEmpleado = $idEmpleado;

        return $this;
    }

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
     * Set idRol
     *
     * @param \AppBundle\Entity\Roles $idRol
     * @return Usuario
     */
    public function setIdRol(\AppBundle\Entity\Roles $idRol = null)
    {
        $this->idRol = $idRol;

        return $this;
    }

    /**
     * Get idRol
     *
     * @return \AppBundle\Entity\Roles
     */
    public function getIdRol()
    {
        return $this->idRol;
    }


    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return !($this->getIsActive()===2);
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        return $this->getIsActive() === 1;
    }

    public function serialize()
    {
        return serialize(array(
            $this->idUi
        ));
    }


    public function unserialize($serialized)
    {
        list(
            $this->idUi

            ) = unserialize($serialized);
    }


    public function getRoles()
    {
        return array($this->idRol);
    }


    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->nomusuario;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function __toString() {
        return $this->nomusuario;
    }

}