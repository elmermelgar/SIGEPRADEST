<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InformacionAcademica
 *
 * @ORM\Table(name="informacion_academica", uniqueConstraints={@ORM\UniqueConstraint(name="informacion_academica_pk", columns={"id_ifacad"})}, indexes={@ORM\Index(name="relationship_12_fk", columns={"id_solicitud"})})
 * @ORM\Entity
 */
class InformacionAcademica
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_ifacad", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="informacion_academica_id_ifacad_seq", allocationSize=1, initialValue=1)
     */
    private $idIfacad;

    /**
     * @var string
     *
     * @ORM\Column(name="institucion", type="string", length=100, nullable=true)
     */
    private $institucion;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=100, nullable=true)
     */
    private $titulo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_obtenido", type="date", nullable=true)
     */
    private $fechaObtenido;

    /**
     * @var \Solicitud
     *
     * @ORM\ManyToOne(targetEntity="Solicitud")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_solicitud", referencedColumnName="id_solicitud")
     * })
     */
    private $idSolicitud;



    /**
     * Get idIfacad
     *
     * @return integer 
     */
    public function getIdIfacad()
    {
        return $this->idIfacad;
    }

    /**
     * Set institucion
     *
     * @param string $institucion
     * @return InformacionAcademica
     */
    public function setInstitucion($institucion)
    {
        $this->institucion = $institucion;

        return $this;
    }

    /**
     * Get institucion
     *
     * @return string 
     */
    public function getInstitucion()
    {
        return $this->institucion;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return InformacionAcademica
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set fechaObtenido
     *
     * @param \DateTime $fechaObtenido
     * @return InformacionAcademica
     */
    public function setFechaObtenido($fechaObtenido)
    {
        $this->fechaObtenido = $fechaObtenido;

        return $this;
    }

    /**
     * Get fechaObtenido
     *
     * @return \DateTime 
     */
    public function getFechaObtenido()
    {
        return $this->fechaObtenido;
    }

    /**
     * Set idSolicitud
     *
     * @param \AppBundle\Entity\Solicitud $idSolicitud
     * @return InformacionAcademica
     */
    public function setIdSolicitud(\AppBundle\Entity\Solicitud $idSolicitud = null)
    {
        $this->idSolicitud = $idSolicitud;

        return $this;
    }

    /**
     * Get idSolicitud
     *
     * @return \AppBundle\Entity\Solicitud 
     */
    public function getIdSolicitud()
    {
        return $this->idSolicitud;
    }
}
