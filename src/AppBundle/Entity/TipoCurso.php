<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoCurso
 *
 * @ORM\Table(name="tipo_curso", uniqueConstraints={@ORM\UniqueConstraint(name="tipo_curso_pk", columns={"id_tc"})})
 * @ORM\Entity
 */
class TipoCurso
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_tc", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="tipo_curso_id_tc_seq", allocationSize=1, initialValue=1)
     */
    private $idTc;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_tc", type="string", length=50, nullable=true)
     */
    private $nombreTc;



    /**
     * Get idTc
     *
     * @return integer 
     */
    public function getIdTc()
    {
        return $this->idTc;
    }

    /**
     * Set nombreTc
     *
     * @param string $nombreTc
     * @return TipoCurso
     */
    public function setNombreTc($nombreTc)
    {
        $this->nombreTc = $nombreTc;

        return $this;
    }

    /**
     * Get nombreTc
     *
     * @return string 
     */
    public function getNombreTc()
    {
        return $this->nombreTc;
    }
}
