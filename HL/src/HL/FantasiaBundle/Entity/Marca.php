<?php

namespace HL\FantasiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Marca
 *
 * @ORM\Table(name="Marca")
 * @ORM\Entity(repositoryClass="HL\FantasiaBundle\Entity\MarcaRepository")
 */
class Marca
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

	/**
     * @ORM\ManyToOne(targetEntity="AsignacionMarcaModelo", inversedBy="marcas")
     * @ORM\JoinColumn(name="asignacion_id", referencedColumnName="id")
     */
    protected $asignaciones;
	
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Marca
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }
}
