<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExperienciaLaboral
 *
 * @ORM\Table(name="experiencia_laboral", uniqueConstraints={@ORM\UniqueConstraint(name="experiencia_laboral_pk", columns={"id_el"})}, indexes={@ORM\Index(name="z_fk", columns={"id_curriculum"})})
 * @ORM\Entity
 */
class ExperienciaLaboral
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_el", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="experiencia_laboral_id_el_seq", allocationSize=1, initialValue=1)
     */
    private $idEl;

    /**
     * @var string
     *
     * @ORM\Column(name="institucion_el", type="string", length=100, nullable=true)
     */
    private $institucionEl;

    /**
     * @var string
     *
     * @ORM\Column(name="cargo_el", type="string", length=60, nullable=true)
     */
    private $cargoEl;

    /**
     * @var string
     *
     * @ORM\Column(name="pais_el", type="string", length=60, nullable=true)
     */
    private $paisEl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio_el", type="date", nullable=true)
     */
    private $fechaInicioEl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_fin_el", type="date", nullable=true)
     */
    private $fechaFinEl;

    /**
     * @var string
     *
     * @ORM\Column(name="info_adicional_el", type="string", length=200, nullable=true)
     */
    private $infoAdicionalEl;

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
     * Get idEl
     *
     * @return integer 
     */
    public function getIdEl()
    {
        return $this->idEl;
    }

    /**
     * Set institucionEl
     *
     * @param string $institucionEl
     * @return ExperienciaLaboral
     */
    public function setInstitucionEl($institucionEl)
    {
        $this->institucionEl = $institucionEl;

        return $this;
    }

    /**
     * Get institucionEl
     *
     * @return string 
     */
    public function getInstitucionEl()
    {
        return $this->institucionEl;
    }

    /**
     * Set cargoEl
     *
     * @param string $cargoEl
     * @return ExperienciaLaboral
     */
    public function setCargoEl($cargoEl)
    {
        $this->cargoEl = $cargoEl;

        return $this;
    }

    /**
     * Get cargoEl
     *
     * @return string 
     */
    public function getCargoEl()
    {
        return $this->cargoEl;
    }

    /**
     * Set paisEl
     *
     * @param string $paisEl
     * @return ExperienciaLaboral
     */
    public function setPaisEl($paisEl)
    {
        $this->paisEl = $paisEl;

        return $this;
    }

    /**
     * Get paisEl
     *
     * @return string 
     */
    public function getPaisEl()
    {
        return $this->paisEl;
    }

    /**
     * Set fechaInicioEl
     *
     * @param \DateTime $fechaInicioEl
     * @return ExperienciaLaboral
     */
    public function setFechaInicioEl($fechaInicioEl)
    {
        $this->fechaInicioEl = $fechaInicioEl;

        return $this;
    }

    /**
     * Get fechaInicioEl
     *
     * @return \DateTime 
     */
    public function getFechaInicioEl()
    {
        return $this->fechaInicioEl;
    }

    /**
     * Set fechaFinEl
     *
     * @param \DateTime $fechaFinEl
     * @return ExperienciaLaboral
     */
    public function setFechaFinEl($fechaFinEl)
    {
        $this->fechaFinEl = $fechaFinEl;

        return $this;
    }

    /**
     * Get fechaFinEl
     *
     * @return \DateTime 
     */
    public function getFechaFinEl()
    {
        return $this->fechaFinEl;
    }

    /**
     * Set infoAdicionalEl
     *
     * @param string $infoAdicionalEl
     * @return ExperienciaLaboral
     */
    public function setInfoAdicionalEl($infoAdicionalEl)
    {
        $this->infoAdicionalEl = $infoAdicionalEl;

        return $this;
    }

    /**
     * Get infoAdicionalEl
     *
     * @return string 
     */
    public function getInfoAdicionalEl()
    {
        return $this->infoAdicionalEl;
    }

    /**
     * Set idCurriculum
     *
     * @param \AppBundle\Entity\Curriculum $idCurriculum
     * @return ExperienciaLaboral
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
