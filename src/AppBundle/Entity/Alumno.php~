<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alumno
 *
 * @ORM\Table(name="alumno", uniqueConstraints={@ORM\UniqueConstraint(name="alumno_pk", columns={"id_alumno"})}, indexes={@ORM\Index(name="i_fk", columns={"id_ui"}), @ORM\Index(name="k2_fk", columns={"id_dp"})})
 * @ORM\Entity
 */
class Alumno
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_alumno", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="alumno_id_alumno_seq", allocationSize=1, initialValue=1)
     */
    private $idAlumno;

    /**
     * @var string
     *
     * @ORM\Column(name="estado_alumno", type="string", length=50, nullable=true)
     */
    private $estadoAlumno;

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
     * @var \DatosPersonales
     *
     * @ORM\ManyToOne(targetEntity="DatosPersonales")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_dp", referencedColumnName="id_dp")
     * })
     */
    private $idDp;



    /**
     * Get idAlumno
     *
     * @return integer 
     */
    public function getIdAlumno()
    {
        return $this->idAlumno;
    }

    /**
     * Set estadoAlumno
     *
     * @param string $estadoAlumno
     * @return Alumno
     */
    public function setEstadoAlumno($estadoAlumno)
    {
        $this->estadoAlumno = $estadoAlumno;

        return $this;
    }

    /**
     * Get estadoAlumno
     *
     * @return string 
     */
    public function getEstadoAlumno()
    {
        return $this->estadoAlumno;
    }

    /**
     * Set idUi
     *
     * @param \AppBundle\Entity\Usuario $idUi
     * @return Alumno
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

    /**
     * Set idDp
     *
     * @param \AppBundle\Entity\DatosPersonales $idDp
     * @return Alumno
     */
    public function setIdDp(\AppBundle\Entity\DatosPersonales $idDp = null)
    {
        $this->idDp = $idDp;

        return $this;
    }

    /**
     * Get idDp
     *
     * @return \AppBundle\Entity\DatosPersonales 
     */
    public function getIdDp()
    {
        return $this->idDp;
    }
}
