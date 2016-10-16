<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Curso
 *
 * @ORM\Table(name="curso", uniqueConstraints={@ORM\UniqueConstraint(name="curso_pk", columns={"id_curso"})}, indexes={@ORM\Index(name="o_fk", columns={"id_tc"})})
 * @ORM\Entity
 */
class Curso
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_curso", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="curso_id_curso_seq", allocationSize=1, initialValue=1)
     */
    private $idCurso;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_curso", type="string", length=200, nullable=true)
     */
    private $nombreCurso;

    /**
     * @var integer
     *
     * @ORM\Column(name="cant_alumnos_limit", type="integer", nullable=true)
     */
    private $cantAlumnosLimit;

    /**
     * @var string
     *
     * @ORM\Column(name="texto_informativo", type="string", length=400, nullable=true)
     */
    private $textoInformativo;

    /**
     * @var string
     *
     * @ORM\Column(name="broshure_informativo", type="string", length=400, nullable=true)
     */
    private $broshureInformativo;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_cuotas", type="integer", nullable=true)
     */
    private $numCuotas;

    /**
     * @var string
     *
     * @ORM\Column(name="ruta_pdf", type="string", length=200, nullable=true)
     */
    private $rutaPdf;

    /**
     * @var string
     *
     * @ORM\Column(name="estado_curso", type="string", length=50, nullable=true)
     */
    private $estadoCurso;

    /**
     * @var \TipoCurso
     *
     * @ORM\ManyToOne(targetEntity="TipoCurso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tc", referencedColumnName="id_tc")
     * })
     */
    private $idTc;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Doctores", inversedBy="idCurso")
     * @ORM\JoinTable(name="d1",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_curso", referencedColumnName="id_curso")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_doctores", referencedColumnName="id_doctores")
     *   }
     * )
     */
    private $idDoctores;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idDoctores = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get idCurso
     *
     * @return integer 
     */
    public function getIdCurso()
    {
        return $this->idCurso;
    }

    /**
     * Set nombreCurso
     *
     * @param string $nombreCurso
     * @return Curso
     */
    public function setNombreCurso($nombreCurso)
    {
        $this->nombreCurso = $nombreCurso;

        return $this;
    }

    /**
     * Get nombreCurso
     *
     * @return string 
     */
    public function getNombreCurso()
    {
        return $this->nombreCurso;
    }

    /**
     * Set cantAlumnosLimit
     *
     * @param integer $cantAlumnosLimit
     * @return Curso
     */
    public function setCantAlumnosLimit($cantAlumnosLimit)
    {
        $this->cantAlumnosLimit = $cantAlumnosLimit;

        return $this;
    }

    /**
     * Get cantAlumnosLimit
     *
     * @return integer 
     */
    public function getCantAlumnosLimit()
    {
        return $this->cantAlumnosLimit;
    }

    /**
     * Set textoInformativo
     *
     * @param string $textoInformativo
     * @return Curso
     */
    public function setTextoInformativo($textoInformativo)
    {
        $this->textoInformativo = $textoInformativo;

        return $this;
    }

    /**
     * Get textoInformativo
     *
     * @return string 
     */
    public function getTextoInformativo()
    {
        return $this->textoInformativo;
    }

    /**
     * Set broshureInformativo
     *
     * @param string $broshureInformativo
     * @return Curso
     */
    public function setBroshureInformativo($broshureInformativo)
    {
        $this->broshureInformativo = $broshureInformativo;

        return $this;
    }

    /**
     * Get broshureInformativo
     *
     * @return string 
     */
    public function getBroshureInformativo()
    {
        return $this->broshureInformativo;
    }

    /**
     * Set numCuotas
     *
     * @param integer $numCuotas
     * @return Curso
     */
    public function setNumCuotas($numCuotas)
    {
        $this->numCuotas = $numCuotas;

        return $this;
    }

    /**
     * Get numCuotas
     *
     * @return integer 
     */
    public function getNumCuotas()
    {
        return $this->numCuotas;
    }

    /**
     * Set rutaPdf
     *
     * @param string $rutaPdf
     * @return Curso
     */
    public function setRutaPdf($rutaPdf)
    {
        $this->rutaPdf = $rutaPdf;

        return $this;
    }

    /**
     * Get rutaPdf
     *
     * @return string 
     */
    public function getRutaPdf()
    {
        return $this->rutaPdf;
    }

    /**
     * Set estadoCurso
     *
     * @param string $estadoCurso
     * @return Curso
     */
    public function setEstadoCurso($estadoCurso)
    {
        $this->estadoCurso = $estadoCurso;

        return $this;
    }

    /**
     * Get estadoCurso
     *
     * @return string 
     */
    public function getEstadoCurso()
    {
        return $this->estadoCurso;
    }

    /**
     * Set idTc
     *
     * @param \AppBundle\Entity\TipoCurso $idTc
     * @return Curso
     */
    public function setIdTc(\AppBundle\Entity\TipoCurso $idTc = null)
    {
        $this->idTc = $idTc;

        return $this;
    }

    /**
     * Get idTc
     *
     * @return \AppBundle\Entity\TipoCurso 
     */
    public function getIdTc()
    {
        return $this->idTc;
    }

    /**
     * Add idDoctores
     *
     * @param \AppBundle\Entity\Doctores $idDoctores
     * @return Curso
     */
    public function addIdDoctore(\AppBundle\Entity\Doctores $idDoctores)
    {
        $this->idDoctores[] = $idDoctores;

        return $this;
    }

    /**
     * Remove idDoctores
     *
     * @param \AppBundle\Entity\Doctores $idDoctores
     */
    public function removeIdDoctore(\AppBundle\Entity\Doctores $idDoctores)
    {
        $this->idDoctores->removeElement($idDoctores);
    }

    /**
     * Get idDoctores
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdDoctores()
    {
        return $this->idDoctores;
    }
}
