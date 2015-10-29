<?php

namespace HL\FantasiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Vidrio
 *
 * @ORM\Table(name="Vidrio")
 * @ORM\Entity(repositoryClass="HL\FantasiaBundle\Entity\VidrioRepository")
 */
class Vidrio
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
     * @ORM\Column(name="tipo", type="string", length=100)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="precioxm2", type="decimal", scale=2)
     */
    private $precioxm2;
	
	/**
     * @ORM\OneToOne(targetEntity="Carpinteria", mappedBy="Vidrio")
     */
    protected $carpinterias;
 
    public function __construct()
    {
        $this->carpinterias = new ArrayCollection();
    }

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
     * Set tipo
     *
     * @param string $tipo
     * @return Vidrio
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set precioxm2
     *
     * @param string $precioxm2
     * @return Vidrio
     */
    public function setPrecioxm2($precioxm2)
    {
        $this->precioxm2 = $precioxm2;

        return $this;
    }

    /**
     * Get precioxm2
     *
     * @return string 
     */
    public function getPrecioxm2()
    {
        return $this->precioxm2;
    }
}
