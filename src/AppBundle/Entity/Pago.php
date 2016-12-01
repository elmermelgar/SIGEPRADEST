<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pago
 *
 * @ORM\Table(name="pago", uniqueConstraints={@ORM\UniqueConstraint(name="pago_pk", columns={"id_pago__"})}, indexes={@ORM\Index(name="f11_fk", columns={"id_especifico__"})})
 * @ORM\Entity
 */
class Pago
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_pago__", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="pago_id_pago___seq", allocationSize=1, initialValue=1)
     */
    private $idPago;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_pago__", type="string", length=100, nullable=true)
     */
    private $nombrePago;

    /**
     * @var string
     *
     * @ORM\Column(name="monto_pago", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $montoPago;

    /**
     * @var \Especifico
     *
     * @ORM\ManyToOne(targetEntity="Especifico")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_especifico__", referencedColumnName="id_especifico__")
     * })
     */
    private $idEspecifico;



    /**
     * Get idPago
     *
     * @return integer 
     */
    public function getIdPago()
    {
        return $this->idPago;
    }

    /**
     * Set nombrePago
     *
     * @param string $nombrePago
     * @return Pago
     */
    public function setNombrePago($nombrePago)
    {
        $this->nombrePago = $nombrePago;

        return $this;
    }

    /**
     * Get nombrePago
     *
     * @return string 
     */
    public function getNombrePago()
    {
        return $this->nombrePago;
    }

    /**
     * @return string
     */
    public function getMontoPago()
    {
        return $this->montoPago;
    }

    /**
     * @param string $montoPago
     */
    public function setMontoPago($montoPago)
    {
        $this->montoPago = $montoPago;
    }

    /**
     * Set idEspecifico
     *
     * @param \AppBundle\Entity\Especifico $idEspecifico
     * @return Pago
     */
    public function setIdEspecifico(\AppBundle\Entity\Especifico $idEspecifico = null)
    {
        $this->idEspecifico = $idEspecifico;

        return $this;
    }

    /**
     * Get idEspecifico
     *
     * @return \AppBundle\Entity\Especifico 
     */
    public function getIdEspecifico()
    {
        return $this->idEspecifico;
    }
}
