<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EvaluacionPrevia
 *
 * @ORM\Table(name="evaluacion_previa", uniqueConstraints={@ORM\UniqueConstraint(name="evaluacion_previa_pk", columns={"id_ev"})}, indexes={@ORM\Index(name="s4_fk", columns={"id_solicitud"}), @ORM\Index(name="s3_fk", columns={"id_he"})})
 * @ORM\Entity
 */
class EvaluacionPrevia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_ev", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="evaluacion_previa_id_ev_seq", allocationSize=1, initialValue=1)
     */
    private $idEv;

    /**
     * @var string
     *
     * @ORM\Column(name="comentario_evaluacion", type="string", length=100, nullable=true)
     */
    private $comentarioEvaluacion;

    /**
     * @var \HorarioEntrevista
     *
     * @ORM\ManyToOne(targetEntity="HorarioEntrevista")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_he", referencedColumnName="id_he")
     * })
     */
    private $idHe;

    /**
     * @var \Solicitud
     *
     * @ORM\ManyToOne(targetEntity="Solicitud")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_solicitud", referencedColumnName="id_solicitud")
     * })
     */
    private $idSolicitud;



    /**
     * Get idEv
     *
     * @return integer 
     */
    public function getIdEv()
    {
        return $this->idEv;
    }

    /**
     * Set comentarioEvaluacion
     *
     * @param string $comentarioEvaluacion
     * @return EvaluacionPrevia
     */
    public function setComentarioEvaluacion($comentarioEvaluacion)
    {
        $this->comentarioEvaluacion = $comentarioEvaluacion;

        return $this;
    }

    /**
     * Get comentarioEvaluacion
     *
     * @return string 
     */
    public function getComentarioEvaluacion()
    {
        return $this->comentarioEvaluacion;
    }

    /**
     * Set idHe
     *
     * @param \AppBundle\Entity\HorarioEntrevista $idHe
     * @return EvaluacionPrevia
     */
    public function setIdHe(\AppBundle\Entity\HorarioEntrevista $idHe = null)
    {
        $this->idHe = $idHe;

        return $this;
    }

    /**
     * Get idHe
     *
     * @return \AppBundle\Entity\HorarioEntrevista 
     */
    public function getIdHe()
    {
        return $this->idHe;
    }

    /**
     * Set idSolicitud
     *
     * @param \AppBundle\Entity\Solicitud $idSolicitud
     * @return EvaluacionPrevia
     */
    public function setIdSolicitud(\AppBundle\Entity\Solicitud $idSolicitud = null)
    {
        $this->idSolicitud = $idSolicitud;

        return $this;
    }

    /**
     * Get idSolicitud
     *
     * @return \AppBundle\Entity\Solicitud 
     */
    public function getIdSolicitud()
    {
        return $this->idSolicitud;
    }
}
