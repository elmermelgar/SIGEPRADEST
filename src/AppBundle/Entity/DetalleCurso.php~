<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetalleCurso
 *
 * @ORM\Table(name="detalle_curso", uniqueConstraints={@ORM\UniqueConstraint(name="detalle_curso_pk", columns={"id_dc"})}, indexes={@ORM\Index(name="q_fk", columns={"id_exp"}), @ORM\Index(name="k_fk", columns={"id_curso"})})
 * @ORM\Entity
 */
class DetalleCurso
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_dc", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="detalle_curso_id_dc_seq", allocationSize=1, initialValue=1)
     */
    private $idDc;

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
     * @var \Expediente
     *
     * @ORM\ManyToOne(targetEntity="Expediente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_exp", referencedColumnName="id_exp")
     * })
     */
    private $idExp;



    /**
     * Get idDc
     *
     * @return integer 
     */
    public function getIdDc()
    {
        return $this->idDc;
    }

    /**
     * Set idCurso
     *
     * @param \AppBundle\Entity\Curso $idCurso
     * @return DetalleCurso
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

    /**
     * Set idExp
     *
     * @param \AppBundle\Entity\Expediente $idExp
     * @return DetalleCurso
     */
    public function setIdExp(\AppBundle\Entity\Expediente $idExp = null)
    {
        $this->idExp = $idExp;

        return $this;
    }

    /**
     * Get idExp
     *
     * @return \AppBundle\Entity\Expediente 
     */
    public function getIdExp()
    {
        return $this->idExp;
    }
}
