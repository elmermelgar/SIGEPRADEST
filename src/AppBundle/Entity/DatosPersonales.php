<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosPersonales
 *
 * @ORM\Table(name="datos_personales", uniqueConstraints={@ORM\UniqueConstraint(name="datos_personales_pk", columns={"id_dp"})}, indexes={@ORM\Index(name="r2_fk", columns={"id_ui"})})
 * @ORM\Entity
 */
class DatosPersonales
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_dp", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_personales_id_dp_seq", allocationSize=1, initialValue=1)
     */
    private $idDp;

    /**
     * @var string
     *
     * @ORM\Column(name="dui_alumno", type="string", length=11, nullable=true)
     */
    private $duiAlumno;

    /**
     * @var string
     *
     * @ORM\Column(name="nit_alumno", type="string", length=19, nullable=true)
     */
    private $nitAlumno;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     */
    private $fechaNacimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="estado_civil", type="string", length=30, nullable=true)
     */
    private $estadoCivil;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion_particular", type="string", length=300, nullable=true)
     */
    private $direccionParticular;

    /**
     * @var string
     *
     * @ORM\Column(name="lugar_trabajo", type="string", length=100, nullable=true)
     */
    private $lugarTrabajo;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion_trabajo", type="string", length=300, nullable=true)
     */
    private $direccionTrabajo;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_movil", type="string", length=9, nullable=true)
     */
    private $telefonoMovil;

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
     * Get idDp
     *
     * @return integer 
     */
    public function getIdDp()
    {
        return $this->idDp;
    }

    /**
     * Set duiAlumno
     *
     * @param string $duiAlumno
     * @return DatosPersonales
     */
    public function setDuiAlumno($duiAlumno)
    {
        $this->duiAlumno = $duiAlumno;

        return $this;
    }

    /**
     * Get duiAlumno
     *
     * @return string 
     */
    public function getDuiAlumno()
    {
        return $this->duiAlumno;
    }

    /**
     * Set nitAlumno
     *
     * @param string $nitAlumno
     * @return DatosPersonales
     */
    public function setNitAlumno($nitAlumno)
    {
        $this->nitAlumno = $nitAlumno;

        return $this;
    }

    /**
     * Get nitAlumno
     *
     * @return string 
     */
    public function getNitAlumno()
    {
        return $this->nitAlumno;
    }

    /**
     * Set fechaNacimeitno
     *
     * @param \DateTime $fechaNacimeitno
     * @return DatosPersonales
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime 
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set estadoCivil
     *
     * @param string $estadoCivil
     * @return DatosPersonales
     */
    public function setEstadoCivil($estadoCivil)
    {
        $this->estadoCivil = $estadoCivil;

        return $this;
    }

    /**
     * Get estadoCivil
     *
     * @return string 
     */
    public function getEstadoCivil()
    {
        return $this->estadoCivil;
    }

    /**
     * Set direccionParticular
     *
     * @param string $direccionParticular
     * @return DatosPersonales
     */
    public function setDireccionParticular($direccionParticular)
    {
        $this->direccionParticular = $direccionParticular;

        return $this;
    }

    /**
     * Get direccionParticular
     *
     * @return string 
     */
    public function getDireccionParticular()
    {
        return $this->direccionParticular;
    }

    /**
     * Set lugarTrabajo
     *
     * @param string $lugarTrabajo
     * @return DatosPersonales
     */
    public function setLugarTrabajo($lugarTrabajo)
    {
        $this->lugarTrabajo = $lugarTrabajo;

        return $this;
    }

    /**
     * Get lugarTrabajo
     *
     * @return string 
     */
    public function getLugarTrabajo()
    {
        return $this->lugarTrabajo;
    }

    /**
     * Set direccionTrabajo
     *
     * @param string $direccionTrabajo
     * @return DatosPersonales
     */
    public function setDireccionTrabajo($direccionTrabajo)
    {
        $this->direccionTrabajo = $direccionTrabajo;

        return $this;
    }

    /**
     * Get direccionTrabajo
     *
     * @return string 
     */
    public function getDireccionTrabajo()
    {
        return $this->direccionTrabajo;
    }

    /**
     * Set telefonoMovil
     *
     * @param string $telefonoMovil
     * @return DatosPersonales
     */
    public function setTelefonoMovil($telefonoMovil)
    {
        $this->telefonoMovil = $telefonoMovil;

        return $this;
    }

    /**
     * Get telefonoMovil
     *
     * @return string 
     */
    public function getTelefonoMovil()
    {
        return $this->telefonoMovil;
    }

    /**
     * Set idUi
     *
     * @param \AppBundle\Entity\Usuario $idUi
     * @return DatosPersonales
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
}
