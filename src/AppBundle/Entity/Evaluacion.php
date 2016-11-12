<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evaluacion
 *
 * @ORM\Table(name="evaluacion", uniqueConstraints={@ORM\UniqueConstraint(name="evaluacion_pk", columns={"id_evaluacion"})})
 * @ORM\Entity
 */
class Evaluacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_evaluacion", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="evaluacion_id_evaluacion_seq", allocationSize=1, initialValue=1)
     */
    private $idEvaluacion;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_evaluacion", type="string", length=50, nullable=true)
     */
    private $nombreEvaluacion;

    /**
     * @var string
     *
     * @ORM\Column(name="porcentaje", type="integer", nullable=true)
     */
    private $porcentaje;

    /**
     * @var \Modulos
     *
     * @ORM\ManyToOne(targetEntity="Modulos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_modulo", referencedColumnName="id_modulo")
     * })
     */
    private $idModulo;



    /**
     * Get idEvaluacion
     *
     * @return integer 
     */
    public function getIdEvaluacion()
    {
        return $this->idEvaluacion;
    }

    /**
     * Set nombreEvaluacion
     *
     * @param string $nombreEvaluacion
     * @return Evaluacion
     */
    public function setNombreEvaluacion($nombreEvaluacion)
    {
        $this->nombreEvaluacion = $nombreEvaluacion;

        return $this;
    }

    /**
     * Get nombreEvaluacion
     *
     * @return string 
     */
    public function getNombreEvaluacion()
    {
        return $this->nombreEvaluacion;
    }

    /**
     * Set porcentaje
     *
     * @param string $porcentaje
     * @return Evaluacion
     */
    public function setPorcentaje($porcentaje)
    {
        $this->porcentaje = $porcentaje;

        return $this;
    }

    /**
     * Get porcentaje
     *
     * @return string 
     */
    public function getPorcentaje()
    {
        return $this->porcentaje;
    }

    /**
     * Set idModulo
     *
     * @param \AppBundle\Entity\Modulos $idModulo
     * @return Nota
     */
    public function setIdModulo(\AppBundle\Entity\Modulos $idModulo = null)
    {
        $this->idModulo = $idModulo;

        return $this;
    }

    /**
     * Get idModulo
     *
     * @return \AppBundle\Entity\Modulos
     */
    public function getIdModulo()
    {
        return $this->idModulo;
    }
}
