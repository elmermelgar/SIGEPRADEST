<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetalleHorario
 *
 * @ORM\Table(name="detalle_horario", uniqueConstraints={@ORM\UniqueConstraint(name="detalle_horario_pk", columns={"id_dhe"})}, indexes={@ORM\Index(name="a_fk", columns={"id_he"})})
 * @ORM\Entity
 */
class DetalleHorario
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_dhe", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="detalle_horario_id_dhe_seq", allocationSize=1, initialValue=1)
     */
    private $idDhe;

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
     * @var \HorarioEntrevista
     *
     * @ORM\ManyToOne(targetEntity="HorarioEntrevista")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_he", referencedColumnName="id_he")
     * })
     */
    private $idHe;



    /**
     * Get idDhe
     *
     * @return integer 
     */
    public function getIdDhe()
    {
        return $this->idDhe;
    }

    /**
     * Set horaDhe
     *
     * @param \DateTime $horaDhe
     * @return DetalleHorario
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
     * @return DetalleHorario
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
     * @return DetalleHorario
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
     * Set idHe
     *
     * @param \AppBundle\Entity\HorarioEntrevista $idHe
     * @return DetalleHorario
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
}
