<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HorarioEntrevista
 *
 * @ORM\Table(name="horario_entrevista", uniqueConstraints={@ORM\UniqueConstraint(name="horario_entrevista_pk", columns={"id_he"})})
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
     * @ORM\Column(name="defecha", type="date", nullable=true)
     */
    private $defecha;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="afecha", type="date", nullable=true)
     */
    private $afecha;



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
     * Set defecha
     *
     * @param \DateTime $defecha
     * @return HorarioEntrevista
     */
    public function setDefecha($defecha)
    {
        $this->defecha = $defecha;

        return $this;
    }

    /**
     * Get defecha
     *
     * @return \DateTime 
     */
    public function getDefecha()
    {
        return $this->defecha;
    }

    /**
     * Set afecha
     *
     * @param \DateTime $afecha
     * @return HorarioEntrevista
     */
    public function setAfecha($afecha)
    {
        $this->afecha = $afecha;

        return $this;
    }

    /**
     * Get afecha
     *
     * @return \DateTime 
     */
    public function getAfecha()
    {
        return $this->afecha;
    }
}
