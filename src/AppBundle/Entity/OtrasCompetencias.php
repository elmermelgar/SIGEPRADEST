<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OtrasCompetencias
 *
 * @ORM\Table(name="otras_competencias", uniqueConstraints={@ORM\UniqueConstraint(name="otras_competencias_pk", columns={"id_oc"})}, indexes={@ORM\Index(name="b1_fk", columns={"id_curriculum"})})
 * @ORM\Entity
 */
class OtrasCompetencias
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_oc", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="otras_competencias_id_oc_seq", allocationSize=1, initialValue=1)
     */
    private $idOc;

    /**
     * @var string
     *
     * @ORM\Column(name="competencia", type="string", length=100, nullable=true)
     */
    private $competencia;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_comp", type="string", length=200, nullable=true)
     */
    private $descripcionComp;

    /**
     * @var \Curriculum
     *
     * @ORM\ManyToOne(targetEntity="Curriculum")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_curriculum", referencedColumnName="id_curriculum")
     * })
     */
    private $idCurriculum;



    /**
     * Get idOc
     *
     * @return integer 
     */
    public function getIdOc()
    {
        return $this->idOc;
    }

    /**
     * Set competencia
     *
     * @param string $competencia
     * @return OtrasCompetencias
     */
    public function setCompetencia($competencia)
    {
        $this->competencia = $competencia;

        return $this;
    }

    /**
     * Get competencia
     *
     * @return string 
     */
    public function getCompetencia()
    {
        return $this->competencia;
    }

    /**
     * Set descripcionComp
     *
     * @param string $descripcionComp
     * @return OtrasCompetencias
     */
    public function setDescripcionComp($descripcionComp)
    {
        $this->descripcionComp = $descripcionComp;

        return $this;
    }

    /**
     * Get descripcionComp
     *
     * @return string 
     */
    public function getDescripcionComp()
    {
        return $this->descripcionComp;
    }

    /**
     * Set idCurriculum
     *
     * @param \AppBundle\Entity\Curriculum $idCurriculum
     * @return OtrasCompetencias
     */
    public function setIdCurriculum(\AppBundle\Entity\Curriculum $idCurriculum = null)
    {
        $this->idCurriculum = $idCurriculum;

        return $this;
    }

    /**
     * Get idCurriculum
     *
     * @return \AppBundle\Entity\Curriculum 
     */
    public function getIdCurriculum()
    {
        return $this->idCurriculum;
    }
}
