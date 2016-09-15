<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReferenciaLaboral
 *
 * @ORM\Table(name="referencia_laboral", uniqueConstraints={@ORM\UniqueConstraint(name="referencia_laboral_pk", columns={"id_rf"})}, indexes={@ORM\Index(name="y_fk", columns={"id_curriculum"})})
 * @ORM\Entity
 */
class ReferenciaLaboral
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_rf", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="referencia_laboral_id_rf_seq", allocationSize=1, initialValue=1)
     */
    private $idRf;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_rf", type="string", length=200, nullable=true)
     */
    private $descripcionRf;

    /**
     * @var string
     *
     * @ORM\Column(name="persona_rf", type="string", length=100, nullable=true)
     */
    private $personaRf;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_rf", type="string", length=9, nullable=true)
     */
    private $telefonoRf;

    /**
     * @var string
     *
     * @ORM\Column(name="puesto_rf", type="string", length=60, nullable=true)
     */
    private $puestoRf;

    /**
     * @var string
     *
     * @ORM\Column(name="empresa_origen_rf", type="string", length=100, nullable=true)
     */
    private $empresaOrigenRf;

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
     * Get idRf
     *
     * @return integer 
     */
    public function getIdRf()
    {
        return $this->idRf;
    }

    /**
     * Set descripcionRf
     *
     * @param string $descripcionRf
     * @return ReferenciaLaboral
     */
    public function setDescripcionRf($descripcionRf)
    {
        $this->descripcionRf = $descripcionRf;

        return $this;
    }

    /**
     * Get descripcionRf
     *
     * @return string 
     */
    public function getDescripcionRf()
    {
        return $this->descripcionRf;
    }

    /**
     * Set personaRf
     *
     * @param string $personaRf
     * @return ReferenciaLaboral
     */
    public function setPersonaRf($personaRf)
    {
        $this->personaRf = $personaRf;

        return $this;
    }

    /**
     * Get personaRf
     *
     * @return string 
     */
    public function getPersonaRf()
    {
        return $this->personaRf;
    }

    /**
     * Set telefonoRf
     *
     * @param string $telefonoRf
     * @return ReferenciaLaboral
     */
    public function setTelefonoRf($telefonoRf)
    {
        $this->telefonoRf = $telefonoRf;

        return $this;
    }

    /**
     * Get telefonoRf
     *
     * @return string 
     */
    public function getTelefonoRf()
    {
        return $this->telefonoRf;
    }

    /**
     * Set puestoRf
     *
     * @param string $puestoRf
     * @return ReferenciaLaboral
     */
    public function setPuestoRf($puestoRf)
    {
        $this->puestoRf = $puestoRf;

        return $this;
    }

    /**
     * Get puestoRf
     *
     * @return string 
     */
    public function getPuestoRf()
    {
        return $this->puestoRf;
    }

    /**
     * Set empresaOrigenRf
     *
     * @param string $empresaOrigenRf
     * @return ReferenciaLaboral
     */
    public function setEmpresaOrigenRf($empresaOrigenRf)
    {
        $this->empresaOrigenRf = $empresaOrigenRf;

        return $this;
    }

    /**
     * Get empresaOrigenRf
     *
     * @return string 
     */
    public function getEmpresaOrigenRf()
    {
        return $this->empresaOrigenRf;
    }

    /**
     * Set idCurriculum
     *
     * @param \AppBundle\Entity\Curriculum $idCurriculum
     * @return ReferenciaLaboral
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
