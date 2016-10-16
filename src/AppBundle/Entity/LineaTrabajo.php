<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LineaTrabajo
 *
 * @ORM\Table(name="linea_trabajo", uniqueConstraints={@ORM\UniqueConstraint(name="linea_trabajo_pk", columns={"id_linea_trabajo__"})}, indexes={@ORM\Index(name="f5_fk", columns={"id_unidad_presupuestaria__"})})
 * @ORM\Entity
 */
class LineaTrabajo
{
    /**
     * @var string
     *
     * @ORM\Column(name="id_linea_trabajo__", type="string", length=10, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="linea_trabajo_id_linea_trabajo___seq", allocationSize=1, initialValue=1)
     */
    private $idLineaTrabajo;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_linea_trabajo__", type="string", length=10, nullable=true)
     */
    private $codLineaTrabajo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_linea_trabajo__", type="string", length=100, nullable=true)
     */
    private $nombreLineaTrabajo;

    /**
     * @var \UnidadPresupuesto
     *
     * @ORM\ManyToOne(targetEntity="UnidadPresupuesto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_unidad_presupuestaria__", referencedColumnName="id_unidad_presupuestaria__")
     * })
     */
    private $idUnidadPresupuestaria;



    /**
     * Get idLineaTrabajo
     *
     * @return string 
     */
    public function getIdLineaTrabajo()
    {
        return $this->idLineaTrabajo;
    }

    /**
     * Set codLineaTrabajo
     *
     * @param string $codLineaTrabajo
     * @return LineaTrabajo
     */
    public function setCodLineaTrabajo($codLineaTrabajo)
    {
        $this->codLineaTrabajo = $codLineaTrabajo;

        return $this;
    }

    /**
     * Get codLineaTrabajo
     *
     * @return string 
     */
    public function getCodLineaTrabajo()
    {
        return $this->codLineaTrabajo;
    }

    /**
     * Set nombreLineaTrabajo
     *
     * @param string $nombreLineaTrabajo
     * @return LineaTrabajo
     */
    public function setNombreLineaTrabajo($nombreLineaTrabajo)
    {
        $this->nombreLineaTrabajo = $nombreLineaTrabajo;

        return $this;
    }

    /**
     * Get nombreLineaTrabajo
     *
     * @return string 
     */
    public function getNombreLineaTrabajo()
    {
        return $this->nombreLineaTrabajo;
    }

    /**
     * Set idUnidadPresupuestaria
     *
     * @param \AppBundle\Entity\UnidadPresupuesto $idUnidadPresupuestaria
     * @return LineaTrabajo
     */
    public function setIdUnidadPresupuestaria(\AppBundle\Entity\UnidadPresupuesto $idUnidadPresupuestaria = null)
    {
        $this->idUnidadPresupuestaria = $idUnidadPresupuestaria;

        return $this;
    }

    /**
     * Get idUnidadPresupuestaria
     *
     * @return \AppBundle\Entity\UnidadPresupuesto 
     */
    public function getIdUnidadPresupuestaria()
    {
        return $this->idUnidadPresupuestaria;
    }
}
