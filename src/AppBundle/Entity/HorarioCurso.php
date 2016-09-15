<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HorarioCurso
 *
 * @ORM\Table(name="horario_curso", uniqueConstraints={@ORM\UniqueConstraint(name="horario_curso_pk", columns={"id_hc"})})
 * @ORM\Entity
 */
class HorarioCurso
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_hc", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="horario_curso_id_hc_seq", allocationSize=1, initialValue=1)
     */
    private $idHc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="date", nullable=true)
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_fin", type="date", nullable=true)
     */
    private $fechaFin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="inicio_recep_doc", type="date", nullable=true)
     */
    private $inicioRecepDoc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fin_recep_doc", type="date", nullable=true)
     */
    private $finRecepDoc;



    /**
     * Get idHc
     *
     * @return integer 
     */
    public function getIdHc()
    {
        return $this->idHc;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     * @return HorarioCurso
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime 
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     * @return HorarioCurso
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    /**
     * Get fechaFin
     *
     * @return \DateTime 
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    /**
     * Set inicioRecepDoc
     *
     * @param \DateTime $inicioRecepDoc
     * @return HorarioCurso
     */
    public function setInicioRecepDoc($inicioRecepDoc)
    {
        $this->inicioRecepDoc = $inicioRecepDoc;

        return $this;
    }

    /**
     * Get inicioRecepDoc
     *
     * @return \DateTime 
     */
    public function getInicioRecepDoc()
    {
        return $this->inicioRecepDoc;
    }

    /**
     * Set finRecepDoc
     *
     * @param \DateTime $finRecepDoc
     * @return HorarioCurso
     */
    public function setFinRecepDoc($finRecepDoc)
    {
        $this->finRecepDoc = $finRecepDoc;

        return $this;
    }

    /**
     * Get finRecepDoc
     *
     * @return \DateTime 
     */
    public function getFinRecepDoc()
    {
        return $this->finRecepDoc;
    }
}
