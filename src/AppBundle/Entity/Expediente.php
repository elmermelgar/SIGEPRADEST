<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Expediente
 *
 * @ORM\Table(name="expediente", uniqueConstraints={@ORM\UniqueConstraint(name="expediente_pk", columns={"id_exp"})}, indexes={@ORM\Index(name="j_fk", columns={"id_alumno"})})
 * @ORM\Entity
 */
class Expediente
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_exp", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="expediente_id_exp_seq", allocationSize=1, initialValue=1)
     */
    private $idExp;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_exp", type="string", length=100, nullable=true)
     */
    private $nombreExp;

    /**
     * @var string
     *
     * @ORM\Column(name="datos_carrera", type="string", length=200, nullable=true)
     */
    private $datosCarrera;

    /**
     * @var string
     *
     * @ORM\Column(name="genero", type="string", length=15, nullable=true)
     */
    private $genero;

    /**
     * @var string
     *
     * @ORM\Column(name="pais_nacimiento", type="string", length=30, nullable=true)
     */
    private $paisNacimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="nacionalidad", type="string", length=40, nullable=true)
     */
    private $nacionalidad;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_naci", type="date", nullable=true)
     */
    private $fechaNaci;

    /**
     * @var string
     *
     * @ORM\Column(name="dui_exp", type="string", length=11, nullable=true)
     */
    private $duiExp;

    /**
     * @var string
     *
     * @ORM\Column(name="nit_exp", type="string", length=17, nullable=true)
     */
    private $nitExp;

    /**
     * @var string
     *
     * @ORM\Column(name="estado_civil_exp", type="string", length=20, nullable=true)
     */
    private $estadoCivilExp;

    /**
     * @var string
     *
     * @ORM\Column(name="situacion_laboral", type="string", length=50, nullable=true)
     */
    private $situacionLaboral;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_estudiante", type="string", length=50, nullable=true)
     */
    private $tipoEstudiante;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion_exp", type="string", length=300, nullable=true)
     */
    private $direccionExp;

    /**
     * @var string
     *
     * @ORM\Column(name="depto_recidencia", type="string", length=40, nullable=true)
     */
    private $deptoRecidencia;

    /**
     * @var string
     *
     * @ORM\Column(name="municipio_recidencia", type="string", length=40, nullable=true)
     */
    private $municipioRecidencia;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=9, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="email_exp", type="string", length=50, nullable=true)
     */
    private $emailExp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_titulacion", type="date", nullable=true)
     */
    private $fechaTitulacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_exp_titulo", type="date", nullable=true)
     */
    private $fechaExpTitulo;

    /**
     * @var string
     *
     * @ORM\Column(name="institucion_exp", type="string", length=50, nullable=true)
     */
    private $institucionExp;

    /**
     * @var string
     *
     * @ORM\Column(name="bachillerato", type="string", length=40, nullable=true)
     */
    private $bachillerato;

    /**
     * @var integer
     *
     * @ORM\Column(name="cambios_carrera_aprob", type="integer", nullable=true)
     */
    private $cambiosCarreraAprob;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="date", nullable=true)
     */
    private $fechaRegistro;

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
     * Get idExp
     *
     * @return integer 
     */
    public function getIdExp()
    {
        return $this->idExp;
    }

    /**
     * Set nombreExp
     *
     * @param string $nombreExp
     * @return Expediente
     */
    public function setNombreExp($nombreExp)
    {
        $this->nombreExp = $nombreExp;

        return $this;
    }

    /**
     * Get nombreExp
     *
     * @return string 
     */
    public function getNombreExp()
    {
        return $this->nombreExp;
    }

    /**
     * Set datosCarrera
     *
     * @param string $datosCarrera
     * @return Expediente
     */
    public function setDatosCarrera($datosCarrera)
    {
        $this->datosCarrera = $datosCarrera;

        return $this;
    }

    /**
     * Get datosCarrera
     *
     * @return string 
     */
    public function getDatosCarrera()
    {
        return $this->datosCarrera;
    }

    /**
     * Set genero
     *
     * @param string $genero
     * @return Expediente
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero
     *
     * @return string 
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set paisNacimiento
     *
     * @param string $paisNacimiento
     * @return Expediente
     */
    public function setPaisNacimiento($paisNacimiento)
    {
        $this->paisNacimiento = $paisNacimiento;

        return $this;
    }

    /**
     * Get paisNacimiento
     *
     * @return string 
     */
    public function getPaisNacimiento()
    {
        return $this->paisNacimiento;
    }

    /**
     * Set nacionalidad
     *
     * @param string $nacionalidad
     * @return Expediente
     */
    public function setNacionalidad($nacionalidad)
    {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }

    /**
     * Get nacionalidad
     *
     * @return string 
     */
    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }

    /**
     * Set fechaNaci
     *
     * @param \DateTime $fechaNaci
     * @return Expediente
     */
    public function setFechaNaci($fechaNaci)
    {
        $this->fechaNaci = $fechaNaci;

        return $this;
    }

    /**
     * Get fechaNaci
     *
     * @return \DateTime 
     */
    public function getFechaNaci()
    {
        return $this->fechaNaci;
    }

    /**
     * Set duiExp
     *
     * @param string $duiExp
     * @return Expediente
     */
    public function setDuiExp($duiExp)
    {
        $this->duiExp = $duiExp;

        return $this;
    }

    /**
     * Get duiExp
     *
     * @return string 
     */
    public function getDuiExp()
    {
        return $this->duiExp;
    }

    /**
     * Set nitExp
     *
     * @param string $nitExp
     * @return Expediente
     */
    public function setNitExp($nitExp)
    {
        $this->nitExp = $nitExp;

        return $this;
    }

    /**
     * Get nitExp
     *
     * @return string 
     */
    public function getNitExp()
    {
        return $this->nitExp;
    }

    /**
     * Set estadoCivilExp
     *
     * @param string $estadoCivilExp
     * @return Expediente
     */
    public function setEstadoCivilExp($estadoCivilExp)
    {
        $this->estadoCivilExp = $estadoCivilExp;

        return $this;
    }

    /**
     * Get estadoCivilExp
     *
     * @return string 
     */
    public function getEstadoCivilExp()
    {
        return $this->estadoCivilExp;
    }

    /**
     * Set situacionLaboral
     *
     * @param string $situacionLaboral
     * @return Expediente
     */
    public function setSituacionLaboral($situacionLaboral)
    {
        $this->situacionLaboral = $situacionLaboral;

        return $this;
    }

    /**
     * Get situacionLaboral
     *
     * @return string 
     */
    public function getSituacionLaboral()
    {
        return $this->situacionLaboral;
    }

    /**
     * Set tipoEstudiante
     *
     * @param string $tipoEstudiante
     * @return Expediente
     */
    public function setTipoEstudiante($tipoEstudiante)
    {
        $this->tipoEstudiante = $tipoEstudiante;

        return $this;
    }

    /**
     * Get tipoEstudiante
     *
     * @return string 
     */
    public function getTipoEstudiante()
    {
        return $this->tipoEstudiante;
    }

    /**
     * Set direccionExp
     *
     * @param string $direccionExp
     * @return Expediente
     */
    public function setDireccionExp($direccionExp)
    {
        $this->direccionExp = $direccionExp;

        return $this;
    }

    /**
     * Get direccionExp
     *
     * @return string 
     */
    public function getDireccionExp()
    {
        return $this->direccionExp;
    }

    /**
     * Set deptoRecidencia
     *
     * @param string $deptoRecidencia
     * @return Expediente
     */
    public function setDeptoRecidencia($deptoRecidencia)
    {
        $this->deptoRecidencia = $deptoRecidencia;

        return $this;
    }

    /**
     * Get deptoRecidencia
     *
     * @return string 
     */
    public function getDeptoRecidencia()
    {
        return $this->deptoRecidencia;
    }

    /**
     * Set municipioRecidencia
     *
     * @param string $municipioRecidencia
     * @return Expediente
     */
    public function setMunicipioRecidencia($municipioRecidencia)
    {
        $this->municipioRecidencia = $municipioRecidencia;

        return $this;
    }

    /**
     * Get municipioRecidencia
     *
     * @return string 
     */
    public function getMunicipioRecidencia()
    {
        return $this->municipioRecidencia;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Expediente
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set emailExp
     *
     * @param string $emailExp
     * @return Expediente
     */
    public function setEmailExp($emailExp)
    {
        $this->emailExp = $emailExp;

        return $this;
    }

    /**
     * Get emailExp
     *
     * @return string 
     */
    public function getEmailExp()
    {
        return $this->emailExp;
    }

    /**
     * Set fechaTitulacion
     *
     * @param \DateTime $fechaTitulacion
     * @return Expediente
     */
    public function setFechaTitulacion($fechaTitulacion)
    {
        $this->fechaTitulacion = $fechaTitulacion;

        return $this;
    }

    /**
     * Get fechaTitulacion
     *
     * @return \DateTime 
     */
    public function getFechaTitulacion()
    {
        return $this->fechaTitulacion;
    }

    /**
     * Set fechaExpTitulo
     *
     * @param \DateTime $fechaExpTitulo
     * @return Expediente
     */
    public function setFechaExpTitulo($fechaExpTitulo)
    {
        $this->fechaExpTitulo = $fechaExpTitulo;

        return $this;
    }

    /**
     * Get fechaExpTitulo
     *
     * @return \DateTime 
     */
    public function getFechaExpTitulo()
    {
        return $this->fechaExpTitulo;
    }

    /**
     * Set institucionExp
     *
     * @param string $institucionExp
     * @return Expediente
     */
    public function setInstitucionExp($institucionExp)
    {
        $this->institucionExp = $institucionExp;

        return $this;
    }

    /**
     * Get institucionExp
     *
     * @return string 
     */
    public function getInstitucionExp()
    {
        return $this->institucionExp;
    }

    /**
     * Set bachillerato
     *
     * @param string $bachillerato
     * @return Expediente
     */
    public function setBachillerato($bachillerato)
    {
        $this->bachillerato = $bachillerato;

        return $this;
    }

    /**
     * Get bachillerato
     *
     * @return string 
     */
    public function getBachillerato()
    {
        return $this->bachillerato;
    }

    /**
     * Set cambiosCarreraAprob
     *
     * @param integer $cambiosCarreraAprob
     * @return Expediente
     */
    public function setCambiosCarreraAprob($cambiosCarreraAprob)
    {
        $this->cambiosCarreraAprob = $cambiosCarreraAprob;

        return $this;
    }

    /**
     * Get cambiosCarreraAprob
     *
     * @return integer 
     */
    public function getCambiosCarreraAprob()
    {
        return $this->cambiosCarreraAprob;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     * @return Expediente
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
     * Set idAlumno
     *
     * @param \AppBundle\Entity\Alumno $idAlumno
     * @return Expediente
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
