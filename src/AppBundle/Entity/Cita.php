<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cita
 *
 * @ORM\Table(name="cita", uniqueConstraints={@ORM\UniqueConstraint(name="cita_pk", columns={"id_cita"})}, indexes={@ORM\Index(name="b_fk", columns={"id_he"}), @ORM\Index(name="c_fk", columns={"id_solicitud"})})
 * @ORM\Entity
 */
class Cita
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_cita", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="cita_id_cita_seq", allocationSize=1, initialValue=1)
     */
    private $idCita;

    /**
     * @var string
     *
     * @ORM\Column(name="comentario_cita", type="string", length=200, nullable=true)
     */
    private $comentarioCita;


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
     * Get idCita
     *
     * @return integer 
     */
    public function getIdCita()
    {
        return $this->idCita;
    }

    /**
     * Set comentarioCita
     *
     * @param string $comentarioCita
     * @return Cita
     */
    public function setComentarioCita($comentarioCita)
    {
        $this->comentarioCita = $comentarioCita;

        return $this;
    }

    /**
     * Get comentarioCita
     *
     * @return string 
     */
    public function getComentarioCita()
    {
        return $this->comentarioCita;
    }


    /**
     * Set idHe
     *
     * @param \AppBundle\Entity\HorarioEntrevista $idHe
     * @return Cita
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
     * @return Cita
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
