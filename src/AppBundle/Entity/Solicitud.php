<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Solicitud
 *
 * @ORM\Table(name="solicitud", uniqueConstraints={@ORM\UniqueConstraint(name="solicitud_pk", columns={"id_solicitud"})}, indexes={@ORM\Index(name="f_fk", columns={"id_ui"}), @ORM\Index(name="n_fk", columns={"id_curso"}), @ORM\Index(name="h_fk", columns={"id_dp"})})
 * @ORM\Entity
 */
class Solicitud
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_solicitud", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="solicitud_id_solicitud_seq", allocationSize=1, initialValue=1)
     */
    private $idSolicitud;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=20, nullable=true)
     */
    private $estado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="date", nullable=true)
     */
    private $fechaRegistro;

    /**
     * @var string
     *
     * @ORM\Column(name="rango_disponibilidad", type="string", length=100, nullable=true)
     */
    private $rangoDisponibilidad;

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
     * @var \Curso
     *
     * @ORM\ManyToOne(targetEntity="Curso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_curso", referencedColumnName="id_curso")
     * })
     */
    private $idCurso;



    /**
     * Get idSolicitud
     *
     * @return integer 
     */
    public function getIdSolicitud()
    {
        return $this->idSolicitud;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return Solicitud
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     * @return Solicitud
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime 
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Set rangoDisponibilidad
     *
     * @param string $rangoDisponibilidad
     * @return Solicitud
     */
    public function setRangoDisponibilidad($rangoDisponibilidad)
    {
        $this->rangoDisponibilidad = $rangoDisponibilidad;

        return $this;
    }

    /**
     * Get rangoDisponibilidad
     *
     * @return string 
     */
    public function getRangoDisponibilidad()
    {
        return $this->rangoDisponibilidad;
    }

    /**
     * Set idUi
     *
     * @param \AppBundle\Entity\Usuario $idUi
     * @return Solicitud
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
     * @return Solicitud
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

    /**
     * Set idCurso
     *
     * @param \AppBundle\Entity\Curso $idCurso
     * @return Solicitud
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
}
