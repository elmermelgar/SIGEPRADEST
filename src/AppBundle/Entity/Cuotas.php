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
     * @ORM\Column(name="descrip_cuota", type="string", length=200, nullable=true)
     */
    private $descripCuota;

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
     * @var \Pago
     *
     * @ORM\ManyToOne(targetEntity="Pago")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pago__", referencedColumnName="id_pago__")
     * })
     */
    private $idPago;

    /**
     * @var \LineaTrabajo
     *
     * @ORM\ManyToOne(targetEntity="LineaTrabajo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_linea_trabajo__", referencedColumnName="id_linea_trabajo__")
     * })
     */
    private $idLineaTrabajo;

    /**
     * @var \CuentaBanco
     *
     * @ORM\ManyToOne(targetEntity="CuentaBanco")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cuenta_banco__", referencedColumnName="id_cuenta_banco__")
     * })
     */
    private $idCuentaBanco;



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
     * @return string
     */
    public function getDescripCuota()
    {
        return $this->descripCuota;
    }

    /**
     * @param string $descripCuota
     */
    public function setDescripCuota($descripCuota)
    {
        $this->descripCuota = $descripCuota;
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

    /**
     * Set idPago
     *
     * @param \AppBundle\Entity\Pago $idPago
     * @return PagoCuota
     */
    public function setIdPago(\AppBundle\Entity\Pago $idPago = null)
    {
        $this->idPago = $idPago;

        return $this;
    }

    /**
     * Get idPago
     *
     * @return \AppBundle\Entity\Pago
     */
    public function getIdPago()
    {
        return $this->idPago;
    }

    /**
     * Set idLineaTrabajo
     *
     * @param \AppBundle\Entity\LineaTrabajo $idLineaTrabajo
     * @return PagoCuota
     */
    public function setIdLineaTrabajo(\AppBundle\Entity\LineaTrabajo $idLineaTrabajo = null)
    {
        $this->idLineaTrabajo = $idLineaTrabajo;

        return $this;
    }

    /**
     * Get idLineaTrabajo
     *
     * @return \AppBundle\Entity\LineaTrabajo
     */
    public function getIdLineaTrabajo()
    {
        return $this->idLineaTrabajo;
    }

    /**
     * Set idCuentaBanco
     *
     * @param \AppBundle\Entity\CuentaBanco $idCuentaBanco
     * @return PagoCuota
     */
    public function setIdCuentaBanco(\AppBundle\Entity\CuentaBanco $idCuentaBanco = null)
    {
        $this->idCuentaBanco = $idCuentaBanco;

        return $this;
    }

    /**
     * Get idCuentaBanco
     *
     * @return \AppBundle\Entity\CuentaBanco
     */
    public function getIdCuentaBanco()
    {
        return $this->idCuentaBanco;
    }
}
