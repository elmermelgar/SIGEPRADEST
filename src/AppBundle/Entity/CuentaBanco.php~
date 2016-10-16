<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CuentaBanco
 *
 * @ORM\Table(name="cuenta_banco", uniqueConstraints={@ORM\UniqueConstraint(name="cuenta_banco_pk", columns={"id_cuenta_banco__"})})
 * @ORM\Entity
 */
class CuentaBanco
{
    /**
     * @var string
     *
     * @ORM\Column(name="id_cuenta_banco__", type="string", length=20, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="cuenta_banco_id_cuenta_banco___seq", allocationSize=1, initialValue=1)
     */
    private $idCuentaBanco;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_cuenta__", type="string", length=100, nullable=true)
     */
    private $nombreCuenta;



    /**
     * Get idCuentaBanco
     *
     * @return string 
     */
    public function getIdCuentaBanco()
    {
        return $this->idCuentaBanco;
    }

    /**
     * Set nombreCuenta
     *
     * @param string $nombreCuenta
     * @return CuentaBanco
     */
    public function setNombreCuenta($nombreCuenta)
    {
        $this->nombreCuenta = $nombreCuenta;

        return $this;
    }

    /**
     * Get nombreCuenta
     *
     * @return string 
     */
    public function getNombreCuenta()
    {
        return $this->nombreCuenta;
    }
}
