<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cita
 *
 * @ORM\Table(name="cita", uniqueConstraints={@ORM\UniqueConstraint(name="cita_pk", columns={"id_cita"})}, indexes={@ORM\Index(name="b_fk", columns={"id_dhe"}), @ORM\Index(name="c_fk", columns={"id_ui"})})
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
     * @var \DetalleHorario
     *
     * @ORM\ManyToOne(targetEntity="DetalleHorario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_dhe", referencedColumnName="id_dhe")
     * })
     */
    private $idDhe;

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ui", referencedColumnName="id_ui")
     * })
     */
    private $idUi;



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
     * Set idDhe
     *
     * @param \AppBundle\Entity\DetalleHorario $idDhe
     * @return Cita
     */
    public function setIdDhe(\AppBundle\Entity\DetalleHorario $idDhe = null)
    {
        $this->idDhe = $idDhe;

        return $this;
    }

    /**
     * Get idDhe
     *
     * @return \AppBundle\Entity\DetalleHorario 
     */
    public function getIdDhe()
    {
        return $this->idDhe;
    }

    /**
     * Set idUi
     *
     * @param \AppBundle\Entity\Usuario $idUi
     * @return Cita
     */
    public function setIdUi(\AppBundle\Entity\Usuario $idUi = null)
    {
        $this->idUi = $idUi;

        return $this;
    }

    /**
     * Get idUi
     *
     * @return \AppBundle\Entity\Usuario 
     */
    public function getIdUi()
    {
        return $this->idUi;
    }
}
