<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HorarioCurso
 *
 * @ORM\Table(name="horario_curso", uniqueConstraints={@ORM\UniqueConstraint(name="horario_curso_pk", columns={"id_hc"})}, indexes={@ORM\Index(name="v_fk", columns={"id_curso"})})
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
     * @var \DateTime
     *
     * @ORM\Column(name="defecha_entrevista", type="date", nullable=true)
     */
    private $defechaEntrevista;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="afecha_entrevista", type="date", nullable=true)
     */
    private $afechaEntrevista;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="defecha_evaluacion", type="date", nullable=true)
     */
    private $defechaEvaluacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="afecha_evaluacion", type="date", nullable=true)
     */
    private $afechaEvaluacion;

    /**
     * @var \Curso
     *
     * @ORM\ManyToOne(targetEntity="Curso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_curso", referencedColumnName="id_curso")
     * })
     */
    private $idCurso;



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

    /**
     * Set defechaEntrevista
     *
     * @param \DateTime $defechaEntrevista
     * @return HorarioCurso
     */
    public function setDefechaEntrevista($defechaEntrevista)
    {
        $this->defechaEntrevista = $defechaEntrevista;

        return $this;
    }

    /**
     * Get defechaEntrevista
     *
     * @return \DateTime 
     */
    public function getDefechaEntrevista()
    {
        return $this->defechaEntrevista;
    }

    /**
     * Set afechaEntrevista
     *
     * @param \DateTime $afechaEntrevista
     * @return HorarioCurso
     */
    public function setAfechaEntrevista($afechaEntrevista)
    {
        $this->afechaEntrevista = $afechaEntrevista;

        return $this;
    }

    /**
     * Get afechaEntrevista
     *
     * @return \DateTime 
     */
    public function getAfechaEntrevista()
    {
        return $this->afechaEntrevista;
    }

    /**
     * Set defechaEvaluacion
     *
     * @param \DateTime $defechaEvaluacion
     * @return HorarioCurso
     */
    public function setDefechaEvaluacion($defechaEvaluacion)
    {
        $this->defechaEvaluacion = $defechaEvaluacion;

        return $this;
    }

    /**
     * Get defechaEvaluacion
     *
     * @return \DateTime 
     */
    public function getDefechaEvaluacion()
    {
        return $this->defechaEvaluacion;
    }

    /**
     * Set afechaEvaluacion
     *
     * @param \DateTime $afechaEvaluacion
     * @return HorarioCurso
     */
    public function setAfechaEvaluacion($afechaEvaluacion)
    {
        $this->afechaEvaluacion = $afechaEvaluacion;

        return $this;
    }

    /**
     * Get afechaEvaluacion
     *
     * @return \DateTime 
     */
    public function getAfechaEvaluacion()
    {
        return $this->afechaEvaluacion;
    }

    /**
     * Set idCurso
     *
     * @param \AppBundle\Entity\Curso $idCurso
     * @return HorarioCurso
     */
    public function setIdCurso(\AppBundle\Entity\Curso $idCurso = null)
    {
        $this->idCurso = $idCurso;

        return $this;
    }

    /**
     * Get idCurso
     *
     * @return \AppBundle\Entity\Curso 
     */
    public function getIdCurso()
    {
        return $this->idCurso;
    }
}
