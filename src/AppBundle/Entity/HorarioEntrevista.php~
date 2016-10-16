<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HorarioEntrevista
 *
 * @ORM\Table(name="horario_entrevista", uniqueConstraints={@ORM\UniqueConstraint(name="horario_entrevista_pk", columns={"id_he"})}, indexes={@ORM\Index(name="s2_fk", columns={"id_curso"})})
 * @ORM\Entity
 */
class HorarioEntrevista
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_he", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="horario_entrevista_id_he_seq", allocationSize=1, initialValue=1)
     */
    private $idHe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_dhe", type="time", nullable=true)
     */
    private $horaDhe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_dhe", type="date", nullable=true)
     */
    private $fechaDhe;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ocupado", type="boolean", nullable=true)
     */
    private $ocupado;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_horario", type="string", length=50, nullable=true)
     */
    private $tipoHorario;

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
     * Get idHe
     *
     * @return integer 
     */
    public function getIdHe()
    {
        return $this->idHe;
    }

    /**
     * Set horaDhe
     *
     * @param \DateTime $horaDhe
     * @return HorarioEntrevista
     */
    public function setHoraDhe($horaDhe)
    {
        $this->horaDhe = $horaDhe;

        return $this;
    }

    /**
     * Get horaDhe
     *
     * @return \DateTime 
     */
    public function getHoraDhe()
    {
        return $this->horaDhe;
    }

    /**
     * Set fechaDhe
     *
     * @param \DateTime $fechaDhe
     * @return HorarioEntrevista
     */
    public function setFechaDhe($fechaDhe)
    {
        $this->fechaDhe = $fechaDhe;

        return $this;
    }

    /**
     * Get fechaDhe
     *
     * @return \DateTime 
     */
    public function getFechaDhe()
    {
        return $this->fechaDhe;
    }

    /**
     * Set ocupado
     *
     * @param boolean $ocupado
     * @return HorarioEntrevista
     */
    public function setOcupado($ocupado)
    {
        $this->ocupado = $ocupado;

        return $this;
    }

    /**
     * Get ocupado
     *
     * @return boolean 
     */
    public function getOcupado()
    {
        return $this->ocupado;
    }

    /**
     * Set tipoHorario
     *
     * @param string $tipoHorario
     * @return HorarioEntrevista
     */
    public function setTipoHorario($tipoHorario)
    {
        $this->tipoHorario = $tipoHorario;

        return $this;
    }

    /**
     * Get tipoHorario
     *
     * @return string 
     */
    public function getTipoHorario()
    {
        return $this->tipoHorario;
    }

    /**
     * Set idCurso
     *
     * @param \AppBundle\Entity\Curso $idCurso
     * @return HorarioEntrevista
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
