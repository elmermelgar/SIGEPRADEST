<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Especifico
 *
 * @ORM\Table(name="especifico", uniqueConstraints={@ORM\UniqueConstraint(name="especifico_pk", columns={"id_especifico__"})})
 * @ORM\Entity
 */
class Especifico
{
    /**
     * @var string
     *
     * @ORM\Column(name="id_especifico__", type="string", length=10, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="especifico_id_especifico___seq", allocationSize=1, initialValue=1)
     */
    private $idEspecifico;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_especifico__", type="string", length=100, nullable=true)
     */
    private $nombreEspecifico;

    /**
     * @var string
     *
     * @ORM\Column(name="padre__", type="string", length=100, nullable=true)
     */
    private $padre;



    /**
     * Get idEspecifico
     *
     * @return string 
     */
    public function getIdEspecifico()
    {
        return $this->idEspecifico;
    }

    /**
     * Set nombreEspecifico
     *
     * @param string $nombreEspecifico
     * @return Especifico
     */
    public function setNombreEspecifico($nombreEspecifico)
    {
        $this->nombreEspecifico = $nombreEspecifico;

        return $this;
    }

    /**
     * Get nombreEspecifico
     *
     * @return string 
     */
    public function getNombreEspecifico()
    {
        return $this->nombreEspecifico;
    }

    /**
     * Set padre
     *
     * @param string $padre
     * @return Especifico
     */
    public function setPadre($padre)
    {
        $this->padre = $padre;

        return $this;
    }

    /**
     * Get padre
     *
     * @return string 
     */
    public function getPadre()
    {
        return $this->padre;
    }
}
