<?php

namespace HL\FantasiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;    

/**
 * Carpinteria
 *
 * @ORM\Table(name="Carpinteria")
 * @ORM\Entity(repositoryClass="HL\FantasiaBundle\Entity\CarpinteriaRepository")
 */
class Carpinteria
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
     * @ORM\Column(name="alto", type="decimal", scale=2)
     */
    private $alto;

    /**
     * @var string
     *
     * @ORM\Column(name="ancho", type="decimal", scale=2)
     */
    private $ancho;

    /**
     * @var boolean
     *
     * @ORM\Column(name="premarco", type="boolean")
     */
    private $premarco;

    /**
     * @var boolean
     *
     * @ORM\Column(name="contramarco", type="boolean")
     */
    private $contramarco;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;

	/**
     * @ORM\ManyToOne(targetEntity="Vidrio", inversedBy="Carpinteria")
     * @ORM\JoinColumn(name="vidrio_id", referencedColumnName="id")
     */
    protected $vidrio;
	
	/**
     * @ORM\ManyToOne(targetEntity="AsignacionMarcaModelo", inversedBy="Carpinteria")
     * @ORM\JoinColumn(name="asignacion_id", referencedColumnName="id")
     */
    protected $asignacion;
	
	/**
     * @ORM\ManyToOne(targetEntity="Presupuesto", inversedBy="Carpinteria")
     * @ORM\JoinColumn(name="presupuesto_id", referencedColumnName="id")
     */
    protected $presupuesto;
	
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
     * Set alto
     *
     * @param string $alto
     * @return Carpinteria
     */
    public function setAlto($alto)
    {
        $this->alto = $alto;

        return $this;
    }

    /**
     * Get alto
     *
     * @return string 
     */
    public function getAlto()
    {
        return $this->alto;
    }

    /**
     * Set ancho
     *
     * @param string $ancho
     * @return Carpinteria
     */
    public function setAncho($ancho)
    {
        $this->ancho = $ancho;

        return $this;
    }

    /**
     * Get ancho
     *
     * @return string 
     */
    public function getAncho()
    {
        return $this->ancho;
    }

    /**
     * Set premarco
     *
     * @param boolean $premarco
     * @return Carpinteria
     */
    public function setPremarco($premarco)
    {
        $this->premarco = $premarco;

        return $this;
    }

    /**
     * Get premarco
     *
     * @return boolean 
     */
    public function getPremarco()
    {
        return $this->premarco;
    }

    /**
     * Set contramarco
     *
     * @param boolean $contramarco
     * @return Carpinteria
     */
    public function setContramarco($contramarco)
    {
        $this->contramarco = $contramarco;

        return $this;
    }

    /**
     * Get contramarco
     *
     * @return boolean 
     */
    public function getContramarco()
    {
        return $this->contramarco;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return Carpinteria
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }
}
