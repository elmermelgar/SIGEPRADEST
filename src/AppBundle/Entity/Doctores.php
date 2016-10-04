<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Doctores
 *
 * @ORM\Table(name="doctores", uniqueConstraints={@ORM\UniqueConstraint(name="doctores_pk", columns={"id_doctores"})})
 * @ORM\Entity
 */
class Doctores
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_doctores", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="doctores_id_doctores_seq", allocationSize=1, initialValue=1)
     */
    private $idDoctores;

    /**
     * @var string
     *
     * @ORM\Column(name="especialidad", type="string", length=50, nullable=true)
     */
    private $especialidad;

    /**
     * @var string
     *
     * @ORM\Column(name="turno", type="string", length=50, nullable=true)
     */
    private $turno;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_doc", type="string", length=100, nullable=true)
     */
    private $nombreDoc;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Curso", mappedBy="idDoctores")
     */
    private $idCurso;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idCurso = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get idDoctores
     *
     * @return integer 
     */
    public function getIdDoctores()
    {
        return $this->idDoctores;
    }

    /**
     * Set especialidad
     *
     * @param string $especialidad
     * @return Doctores
     */
    public function setEspecialidad($especialidad)
    {
        $this->especialidad = $especialidad;

        return $this;
    }

    /**
     * Get especialidad
     *
     * @return string 
     */
    public function getEspecialidad()
    {
        return $this->especialidad;
    }

    /**
     * Set turno
     *
     * @param string $turno
     * @return Doctores
     */
    public function setTurno($turno)
    {
        $this->turno = $turno;

        return $this;
    }

    /**
     * Get turno
     *
     * @return string 
     */
    public function getTurno()
    {
        return $this->turno;
    }

    /**
     * Set nombreDoc
     *
     * @param string $nombreDoc
     * @return Doctores
     */
    public function setNombreDoc($nombreDoc)
    {
        $this->nombreDoc = $nombreDoc;

        return $this;
    }

    /**
     * Get nombreDoc
     *
     * @return string 
     */
    public function getNombreDoc()
    {
        return $this->nombreDoc;
    }

    /**
     * Add idCurso
     *
     * @param \AppBundle\Entity\Curso $idCurso
     * @return Doctores
     */
    public function addIdCurso(\AppBundle\Entity\Curso $idCurso)
    {
        $this->idCurso[] = $idCurso;

        return $this;
    }

    /**
     * Remove idCurso
     *
     * @param \AppBundle\Entity\Curso $idCurso
     */
    public function removeIdCurso(\AppBundle\Entity\Curso $idCurso)
    {
        $this->idCurso->removeElement($idCurso);
    }

    /**
     * Get idCurso
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdCurso()
    {
        return $this->idCurso;
    }
}
