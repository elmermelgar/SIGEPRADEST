<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InscripcionCurso
 *
 * @ORM\Table(name="inscripcion_curso", uniqueConstraints={@ORM\UniqueConstraint(name="inscripcion_curso_pk", columns={"id_dc"})}, indexes={@ORM\Index(name="k_fk", columns={"id_curso"}), @ORM\Index(name="q_fk", columns={"id_alumno"})})
 * @ORM\Entity
 */
class InscripcionCurso
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_dc", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="inscripcion_curso_id_dc_seq", allocationSize=1, initialValue=1)
     */
    private $idDc;

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
     * @var \Alumno
     *
     * @ORM\ManyToOne(targetEntity="Alumno")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_alumno", referencedColumnName="id_alumno")
     * })
     */
    private $idAlumno;



    /**
     * Get idDc
     *
     * @return integer 
     */
    public function getIdDc()
    {
        return $this->idDc;
    }

    /**
     * Set idCurso
     *
     * @param \AppBundle\Entity\Curso $idCurso
     * @return InscripcionCurso
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

    /**
     * Set idAlumno
     *
     * @param \AppBundle\Entity\Alumno $idAlumno
     * @return InscripcionCurso
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
