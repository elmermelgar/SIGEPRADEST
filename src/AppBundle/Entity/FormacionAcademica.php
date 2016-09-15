<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormacionAcademica
 *
 * @ORM\Table(name="formacion_academica", uniqueConstraints={@ORM\UniqueConstraint(name="formacion_academica_pk", columns={"id_fa"})}, indexes={@ORM\Index(name="x_fk", columns={"id_curriculum"})})
 * @ORM\Entity
 */
class FormacionAcademica
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_fa", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="formacion_academica_id_fa_seq", allocationSize=1, initialValue=1)
     */
    private $idFa;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_fa", type="string", length=40, nullable=true)
     */
    private $tipoFa;

    /**
     * @var string
     *
     * @ORM\Column(name="institucion_fa", type="string", length=100, nullable=true)
     */
    private $institucionFa;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio_fa", type="date", nullable=true)
     */
    private $fechaInicioFa;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_fin_fa", type="date", nullable=true)
     */
    private $fechaFinFa;

    /**
     * @var boolean
     *
     * @ORM\Column(name="formal", type="boolean", nullable=true)
     */
    private $formal;

    /**
     * @var string
     *
     * @ORM\Column(name="img_titulo", type="string", length=200, nullable=true)
     */
    private $imgTitulo;

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
     * Get idFa
     *
     * @return integer 
     */
    public function getIdFa()
    {
        return $this->idFa;
    }

    /**
     * Set tipoFa
     *
     * @param string $tipoFa
     * @return FormacionAcademica
     */
    public function setTipoFa($tipoFa)
    {
        $this->tipoFa = $tipoFa;

        return $this;
    }

    /**
     * Get tipoFa
     *
     * @return string 
     */
    public function getTipoFa()
    {
        return $this->tipoFa;
    }

    /**
     * Set institucionFa
     *
     * @param string $institucionFa
     * @return FormacionAcademica
     */
    public function setInstitucionFa($institucionFa)
    {
        $this->institucionFa = $institucionFa;

        return $this;
    }

    /**
     * Get institucionFa
     *
     * @return string 
     */
    public function getInstitucionFa()
    {
        return $this->institucionFa;
    }

    /**
     * Set fechaInicioFa
     *
     * @param \DateTime $fechaInicioFa
     * @return FormacionAcademica
     */
    public function setFechaInicioFa($fechaInicioFa)
    {
        $this->fechaInicioFa = $fechaInicioFa;

        return $this;
    }

    /**
     * Get fechaInicioFa
     *
     * @return \DateTime 
     */
    public function getFechaInicioFa()
    {
        return $this->fechaInicioFa;
    }

    /**
     * Set fechaFinFa
     *
     * @param \DateTime $fechaFinFa
     * @return FormacionAcademica
     */
    public function setFechaFinFa($fechaFinFa)
    {
        $this->fechaFinFa = $fechaFinFa;

        return $this;
    }

    /**
     * Get fechaFinFa
     *
     * @return \DateTime 
     */
    public function getFechaFinFa()
    {
        return $this->fechaFinFa;
    }

    /**
     * Set formal
     *
     * @param boolean $formal
     * @return FormacionAcademica
     */
    public function setFormal($formal)
    {
        $this->formal = $formal;

        return $this;
    }

    /**
     * Get formal
     *
     * @return boolean 
     */
    public function getFormal()
    {
        return $this->formal;
    }

    /**
     * Set imgTitulo
     *
     * @param string $imgTitulo
     * @return FormacionAcademica
     */
    public function setImgTitulo($imgTitulo)
    {
        $this->imgTitulo = $imgTitulo;

        return $this;
    }

    /**
     * Get imgTitulo
     *
     * @return string 
     */
    public function getImgTitulo()
    {
        return $this->imgTitulo;
    }

    /**
     * Set idCurriculum
     *
     * @param \AppBundle\Entity\Curriculum $idCurriculum
     * @return FormacionAcademica
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
