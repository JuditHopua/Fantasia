<?php

namespace HL\FantasiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Modelo
 *
 * @ORM\Table(name="Modelo")
 * @ORM\Entity(repositoryClass="HL\FantasiaBundle\Entity\ModeloRepository")
 */
class Modelo
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
     * @ORM\OneToMany(targetEntity="AsignacionMarcaModelo", mappedBy="modelo")
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
     * @return Modelo
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
	
	  public function __construct()
    {
        $this->asignaciones = new ArrayCollection();
    }	
    public function getAsignaciones() {
        return $this->asignaciones;
    }
    public function addAsignaciones($asignaciones) {
	    $this->asignaciones[]=$asignaciones;}
}
