<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Curriculum
 *
 * @ORM\Table(name="curriculum", uniqueConstraints={@ORM\UniqueConstraint(name="curriculum_pk", columns={"id_curriculum"})}, indexes={@ORM\Index(name="a1_fk", columns={"id_alumno"})})
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
     * @var \Alumno
     *
     * @ORM\ManyToOne(targetEntity="Alumno")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_alumno", referencedColumnName="id_alumno")
     * })
     */
    private $idAlumno;



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
     * Set idAlumno
     *
     * @param \AppBundle\Entity\Alumno $idAlumno
     * @return Curriculum
     */
    public function setIdAlumno(\AppBundle\Entity\Alumno $idAlumno = null)
    {
        $this->idAlumno = $idAlumno;

        return $this;
    }

    /**
     * Get idAlumno
     *
     * @return \AppBundle\Entity\Alumno 
     */
    public function getIdAlumno()
    {
        return $this->idAlumno;
    }
}
