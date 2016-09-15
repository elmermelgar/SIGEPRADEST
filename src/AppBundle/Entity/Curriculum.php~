<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Curriculum
 *
 * @ORM\Table(name="curriculum", uniqueConstraints={@ORM\UniqueConstraint(name="curriculum_pk", columns={"id_curriculum"})}, indexes={@ORM\Index(name="a1_fk", columns={"id_exp"})})
 * @ORM\Entity
 */
class Curriculum
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_curriculum", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="curriculum_id_curriculum_seq", allocationSize=1, initialValue=1)
     */
    private $idCurriculum;

    /**
     * @var \Expediente
     *
     * @ORM\ManyToOne(targetEntity="Expediente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_exp", referencedColumnName="id_exp")
     * })
     */
    private $idExp;



    /**
     * Get idCurriculum
     *
     * @return integer 
     */
    public function getIdCurriculum()
    {
        return $this->idCurriculum;
    }

    /**
     * Set idExp
     *
     * @param \AppBundle\Entity\Expediente $idExp
     * @return Curriculum
     */
    public function setIdExp(\AppBundle\Entity\Expediente $idExp = null)
    {
        $this->idExp = $idExp;

        return $this;
    }

    /**
     * Get idExp
     *
     * @return \AppBundle\Entity\Expediente 
     */
    public function getIdExp()
    {
        return $this->idExp;
    }
}
