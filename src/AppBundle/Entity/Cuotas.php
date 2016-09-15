<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cuotas
 *
 * @ORM\Table(name="cuotas", uniqueConstraints={@ORM\UniqueConstraint(name="cuotas_pk", columns={"id_cuota"})}, indexes={@ORM\Index(name="s_fk", columns={"id_curso"})})
 * @ORM\Entity
 */
class Cuotas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_cuota", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="cuotas_id_cuota_seq", allocationSize=1, initialValue=1)
     */
    private $idCuota;

    /**
     * @var string
     *
     * @ORM\Column(name="cuota", type="string", length=20, nullable=true)
     */
    private $cuota;

    /**
     * @var string
     *
     * @ORM\Column(name="monto", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $monto;

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
     * Get idCuota
     *
     * @return integer 
     */
    public function getIdCuota()
    {
        return $this->idCuota;
    }

    /**
     * Set cuota
     *
     * @param string $cuota
     * @return Cuotas
     */
    public function setCuota($cuota)
    {
        $this->cuota = $cuota;

        return $this;
    }

    /**
     * Get cuota
     *
     * @return string 
     */
    public function getCuota()
    {
        return $this->cuota;
    }

    /**
     * Set monto
     *
     * @param string $monto
     * @return Cuotas
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return string 
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set idCurso
     *
     * @param \AppBundle\Entity\Curso $idCurso
     * @return Cuotas
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
