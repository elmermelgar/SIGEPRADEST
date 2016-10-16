<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UnidadPresupuesto
 *
 * @ORM\Table(name="unidad_presupuesto", uniqueConstraints={@ORM\UniqueConstraint(name="unidad_presupuesto_pk", columns={"id_unidad_presupuestaria__"})})
 * @ORM\Entity
 */
class UnidadPresupuesto
{
    /**
     * @var string
     *
     * @ORM\Column(name="id_unidad_presupuestaria__", type="string", length=10, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="unidad_presupuesto_id_unidad_presupuestaria___seq", allocationSize=1, initialValue=1)
     */
    private $idUnidadPresupuestaria;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_unidad_presupuestaria__", type="string", length=100, nullable=true)
     */
    private $nombreUnidadPresupuestaria;



    /**
     * Get idUnidadPresupuestaria
     *
     * @return string 
     */
    public function getIdUnidadPresupuestaria()
    {
        return $this->idUnidadPresupuestaria;
    }

    /**
     * Set nombreUnidadPresupuestaria
     *
     * @param string $nombreUnidadPresupuestaria
     * @return UnidadPresupuesto
     */
    public function setNombreUnidadPresupuestaria($nombreUnidadPresupuestaria)
    {
        $this->nombreUnidadPresupuestaria = $nombreUnidadPresupuestaria;

        return $this;
    }

    /**
     * Get nombreUnidadPresupuestaria
     *
     * @return string 
     */
    public function getNombreUnidadPresupuestaria()
    {
        return $this->nombreUnidadPresupuestaria;
    }
}
