<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Idioma
 *
 * @ORM\Table(name="idioma", uniqueConstraints={@ORM\UniqueConstraint(name="idioma_pk", columns={"id_idioma"})}, indexes={@ORM\Index(name="w_fk", columns={"id_curriculum"})})
 * @ORM\Entity
 */
class Idioma
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_idioma", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="idioma_id_idioma_seq", allocationSize=1, initialValue=1)
     */
    private $idIdioma;

    /**
     * @var string
     *
     * @ORM\Column(name="idioma", type="string", length=50, nullable=true)
     */
    private $idioma;

    /**
     * @var string
     *
     * @ORM\Column(name="comprension_auditiva", type="string", length=20, nullable=true)
     */
    private $comprensionAuditiva;

    /**
     * @var string
     *
     * @ORM\Column(name="expresion_oral", type="string", length=20, nullable=true)
     */
    private $expresionOral;

    /**
     * @var string
     *
     * @ORM\Column(name="expresion_escrita", type="string", length=20, nullable=true)
     */
    private $expresionEscrita;

    /**
     * @var boolean
     *
     * @ORM\Column(name="legua_materna", type="boolean", nullable=true)
     */
    private $leguaMaterna;

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
     * Get idIdioma
     *
     * @return integer 
     */
    public function getIdIdioma()
    {
        return $this->idIdioma;
    }

    /**
     * Set idioma
     *
     * @param string $idioma
     * @return Idioma
     */
    public function setIdioma($idioma)
    {
        $this->idioma = $idioma;

        return $this;
    }

    /**
     * Get idioma
     *
     * @return string 
     */
    public function getIdioma()
    {
        return $this->idioma;
    }

    /**
     * Set comprensionAuditiva
     *
     * @param string $comprensionAuditiva
     * @return Idioma
     */
    public function setComprensionAuditiva($comprensionAuditiva)
    {
        $this->comprensionAuditiva = $comprensionAuditiva;

        return $this;
    }

    /**
     * Get comprensionAuditiva
     *
     * @return string 
     */
    public function getComprensionAuditiva()
    {
        return $this->comprensionAuditiva;
    }

    /**
     * Set expresionOral
     *
     * @param string $expresionOral
     * @return Idioma
     */
    public function setExpresionOral($expresionOral)
    {
        $this->expresionOral = $expresionOral;

        return $this;
    }

    /**
     * Get expresionOral
     *
     * @return string 
     */
    public function getExpresionOral()
    {
        return $this->expresionOral;
    }

    /**
     * Set expresionEscrita
     *
     * @param string $expresionEscrita
     * @return Idioma
     */
    public function setExpresionEscrita($expresionEscrita)
    {
        $this->expresionEscrita = $expresionEscrita;

        return $this;
    }

    /**
     * Get expresionEscrita
     *
     * @return string 
     */
    public function getExpresionEscrita()
    {
        return $this->expresionEscrita;
    }

    /**
     * Set leguaMaterna
     *
     * @param boolean $leguaMaterna
     * @return Idioma
     */
    public function setLeguaMaterna($leguaMaterna)
    {
        $this->leguaMaterna = $leguaMaterna;

        return $this;
    }

    /**
     * Get leguaMaterna
     *
     * @return boolean 
     */
    public function getLeguaMaterna()
    {
        return $this->leguaMaterna;
    }

    /**
     * Set idCurriculum
     *
     * @param \AppBundle\Entity\Curriculum $idCurriculum
     * @return Idioma
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
