<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PagoCuota
 *
 * @ORM\Table(name="pago_cuota", uniqueConstraints={@ORM\UniqueConstraint(name="pago_cuota_pk", columns={"id_pagos"})}, indexes={@ORM\Index(name="h1_fk", columns={"id_cuota"}), @ORM\Index(name="m_fk", columns={"id_dc"}), @ORM\Index(name="p4_fk", columns={"id_pago__"}), @ORM\Index(name="p5_fk", columns={"id_linea_trabajo__"}), @ORM\Index(name="p6_fk", columns={"id_cuenta_banco__"})})
 * @ORM\Entity
 */
class PagoCuota
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_pagos", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="pago_cuota_id_pagos_seq", allocationSize=1, initialValue=1)
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
     * @ORM\Column(name="imagen_recibo", type="string", length=200, nullable=true)
     */
    private $imagenRecibo;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_recibo", type="string", length=30, nullable=true)
     */
    private $numeroRecibo;

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
     * @var \InscripcionCurso
     *
     * @ORM\ManyToOne(targetEntity="InscripcionCurso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_dc", referencedColumnName="id_dc")
     * })
     */
    private $idDc;

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
     * @return PagoCuota
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
     * @return PagoCuota
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
     * @return PagoCuota
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
     * Set imagenRecibo
     *
     * @param string $imagenRecibo
     * @return PagoCuota
     */
    public function setImagenRecibo($imagenRecibo)
    {
        $this->imagenRecibo = $imagenRecibo;

        return $this;
    }

    /**
     * Get imagenRecibo
     *
     * @return string 
     */
    public function getImagenRecibo()
    {
        return $this->imagenRecibo;
    }

    /**
     * Set numeroRecibo
     *
     * @param string $numeroRecibo
     * @return PagoCuota
     */
    public function setNumeroRecibo($numeroRecibo)
    {
        $this->numeroRecibo = $numeroRecibo;

        return $this;
    }

    /**
     * Get numeroRecibo
     *
     * @return string 
     */
    public function getNumeroRecibo()
    {
        return $this->numeroRecibo;
    }

    /**
     * Set idCuota
     *
     * @param \AppBundle\Entity\Cuotas $idCuota
     * @return PagoCuota
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
     * @param \AppBundle\Entity\InscripcionCurso $idDc
     * @return PagoCuota
     */
    public function setIdDc(\AppBundle\Entity\InscripcionCurso $idDc = null)
    {
        $this->idDc = $idDc;

        return $this;
    }

    /**
     * Get idDc
     *
     * @return \AppBundle\Entity\InscripcionCurso 
     */
    public function getIdDc()
    {
        return $this->idDc;
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
