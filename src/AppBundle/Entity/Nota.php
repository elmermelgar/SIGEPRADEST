<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nota
 *
 * @ORM\Table(name="nota", uniqueConstraints={@ORM\UniqueConstraint(name="nota_pk", columns={"id_nota"})}, indexes={@ORM\Index(name="r_fk", columns={"id_modulo"}), @ORM\Index(name="p_fk", columns={"id_dc"})})
 * @ORM\Entity
 */
class Nota
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_nota", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="nota_id_nota_seq", allocationSize=1, initialValue=1)
     */
    private $idNota;

    /**
     * @var string
     *
     * @ORM\Column(name="evaluacion", type="string", length=20, nullable=true)
     */
    private $evaluacion;

    /**
     * @var string
     *
     * @ORM\Column(name="nota", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $nota;

    /**
     * @var \DetalleCurso
     *
     * @ORM\ManyToOne(targetEntity="DetalleCurso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_dc", referencedColumnName="id_dc")
     * })
     */
    private $idDc;

    /**
     * @var \Modulos
     *
     * @ORM\ManyToOne(targetEntity="Modulos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_modulo", referencedColumnName="id_modulo")
     * })
     */
    private $idModulo;



    /**
     * Get idNota
     *
     * @return integer 
     */
    public function getIdNota()
    {
        return $this->idNota;
    }

    /**
     * Set evaluacion
     *
     * @param string $evaluacion
     * @return Nota
     */
    public function setEvaluacion($evaluacion)
    {
        $this->evaluacion = $evaluacion;

        return $this;
    }

    /**
     * Get evaluacion
     *
     * @return string 
     */
    public function getEvaluacion()
    {
        return $this->evaluacion;
    }

    /**
     * Set nota
     *
     * @param string $nota
     * @return Nota
     */
    public function setNota($nota)
    {
        $this->nota = $nota;

        return $this;
    }

    /**
     * Get nota
     *
     * @return string 
     */
    public function getNota()
    {
        return $this->nota;
    }

    /**
     * Set idDc
     *
     * @param \AppBundle\Entity\DetalleCurso $idDc
     * @return Nota
     */
    public function setIdDc(\AppBundle\Entity\DetalleCurso $idDc = null)
    {
        $this->idDc = $idDc;

        return $this;
    }

    /**
     * Get idDc
     *
     * @return \AppBundle\Entity\DetalleCurso 
     */
    public function getIdDc()
    {
        return $this->idDc;
    }

    /**
     * Set idModulo
     *
     * @param \AppBundle\Entity\Modulos $idModulo
     * @return Nota
     */
    public function setIdModulo(\AppBundle\Entity\Modulos $idModulo = null)
    {
        $this->idModulo = $idModulo;

        return $this;
    }

    /**
     * Get idModulo
     *
     * @return \AppBundle\Entity\Modulos 
     */
    public function getIdModulo()
    {
        return $this->idModulo;
    }
}
