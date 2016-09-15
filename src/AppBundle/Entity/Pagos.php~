<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pagos
 *
 * @ORM\Table(name="pagos", uniqueConstraints={@ORM\UniqueConstraint(name="pagos_pk", columns={"id_pagos"})}, indexes={@ORM\Index(name="m_fk", columns={"id_dc"}), @ORM\Index(name="a27_fk", columns={"id_cuota"})})
 * @ORM\Entity
 */
class Pagos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_pagos", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="pagos_id_pagos_seq", allocationSize=1, initialValue=1)
     */
    private $idPagos;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_pago", type="date", nullable=true)
     */
    private $fechaPago;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cuota_diferenciada", type="boolean", nullable=true)
     */
    private $cuotaDiferenciada;

    /**
     * @var string
     *
     * @ORM\Column(name="monto_pagado", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $montoPagado;

    /**
     * @var string
     *
     * @ORM\Column(name="recibo", type="string", length=200, nullable=true)
     */
    private $recibo;

    /**
     * @var \Cuotas
     *
     * @ORM\ManyToOne(targetEntity="Cuotas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cuota", referencedColumnName="id_cuota")
     * })
     */
    private $idCuota;

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
     * Get idPagos
     *
     * @return integer 
     */
    public function getIdPagos()
    {
        return $this->idPagos;
    }

    /**
     * Set fechaPago
     *
     * @param \DateTime $fechaPago
     * @return Pagos
     */
    public function setFechaPago($fechaPago)
    {
        $this->fechaPago = $fechaPago;

        return $this;
    }

    /**
     * Get fechaPago
     *
     * @return \DateTime 
     */
    public function getFechaPago()
    {
        return $this->fechaPago;
    }

    /**
     * Set cuotaDiferenciada
     *
     * @param boolean $cuotaDiferenciada
     * @return Pagos
     */
    public function setCuotaDiferenciada($cuotaDiferenciada)
    {
        $this->cuotaDiferenciada = $cuotaDiferenciada;

        return $this;
    }

    /**
     * Get cuotaDiferenciada
     *
     * @return boolean 
     */
    public function getCuotaDiferenciada()
    {
        return $this->cuotaDiferenciada;
    }

    /**
     * Set montoPagado
     *
     * @param string $montoPagado
     * @return Pagos
     */
    public function setMontoPagado($montoPagado)
    {
        $this->montoPagado = $montoPagado;

        return $this;
    }

    /**
     * Get montoPagado
     *
     * @return string 
     */
    public function getMontoPagado()
    {
        return $this->montoPagado;
    }

    /**
     * Set recibo
     *
     * @param string $recibo
     * @return Pagos
     */
    public function setRecibo($recibo)
    {
        $this->recibo = $recibo;

        return $this;
    }

    /**
     * Get recibo
     *
     * @return string 
     */
    public function getRecibo()
    {
        return $this->recibo;
    }

    /**
     * Set idCuota
     *
     * @param \AppBundle\Entity\Cuotas $idCuota
     * @return Pagos
     */
    public function setIdCuota(\AppBundle\Entity\Cuotas $idCuota = null)
    {
        $this->idCuota = $idCuota;

        return $this;
    }

    /**
     * Get idCuota
     *
     * @return \AppBundle\Entity\Cuotas 
     */
    public function getIdCuota()
    {
        return $this->idCuota;
    }

    /**
     * Set idDc
     *
     * @param \AppBundle\Entity\DetalleCurso $idDc
     * @return Pagos
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
}
