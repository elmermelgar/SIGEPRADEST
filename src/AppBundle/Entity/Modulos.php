<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modulos
 *
 * @ORM\Table(name="modulos", uniqueConstraints={@ORM\UniqueConstraint(name="modulos_pk", columns={"id_modulo"})}, indexes={@ORM\Index(name="t_fk", columns={"id_curso"})})
 * @ORM\Entity
 */
class Modulos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_modulo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="modulos_id_modulo_seq", allocationSize=1, initialValue=1)
     */
    private $idModulo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_modulo", type="string", length=50, nullable=true)
     */
    private $nombreModulo;

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
     * Get idModulo
     *
     * @return integer 
     */
    public function getIdModulo()
    {
        return $this->idModulo;
    }

    /**
     * Set nombreModulo
     *
     * @param string $nombreModulo
     * @return Modulos
     */
    public function setNombreModulo($nombreModulo)
    {
        $this->nombreModulo = $nombreModulo;

        return $this;
    }

    /**
     * Get nombreModulo
     *
     * @return string 
     */
    public function getNombreModulo()
    {
        return $this->nombreModulo;
    }

    /**
     * Set idCurso
     *
     * @param \AppBundle\Entity\Curso $idCurso
     * @return Modulos
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
