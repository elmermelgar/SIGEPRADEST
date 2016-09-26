<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Roles
 *
 * @ORM\Table(name="roles", uniqueConstraints={@ORM\UniqueConstraint(name="roles_pk", columns={"id_rol"})})
 * @ORM\Entity
 */
class Roles implements RoleInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_rol", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="roles_id_rol_seq", allocationSize=1, initialValue=1)
     */
    private $idRol;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_rol", type="string", length=40, nullable=true)
     */
    private $nombreRol;



    /**
     * Get idRol
     *
     * @return integer
     */
    public function getIdRol()
    {
        return $this->idRol;
    }

    /**
     * Set nombreRol
     *
     * @param string $nombreRol
     * @return Roles
     */
    public function setNombreRol($nombreRol)
    {
        $this->nombreRol = $nombreRol;

        return $this;
    }

    /**
     * Get nombreRol
     *
     * @return string
     */
    public function getNombreRol()
    {
        return $this->nombreRol;
    }

    /**
     * Returns the role.
     *
     * This method returns a string representation whenever possible.
     *
     * When the role cannot be represented with sufficient precision by a
     * string, it should return null.
     *
     * @return string|null A string representation of the role, or null
     */
    public function getRole(){
        return 'ROLE_'.$this->nombreRol.'';
    }
}