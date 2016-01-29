<?php

namespace HL\FantasiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Presupuesto
 *
 * @ORM\Table(name="Presupuesto")
 * @ORM\Entity(repositoryClass="HL\FantasiaBundle\Entity\PresupuestoRepository")
 */
class Presupuesto
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
     * @var \Date
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="costoEnvio", type="decimal", scale=2)
     */
    private $costoEnvio=0.00;

    /**
     * @var string
     *
     * @ORM\Column(name="costoColocacion", type="decimal", scale=2)
     */
    private $costoColocacion=0.00;

    /**
     * @var integer
     *
     * @ORM\Column(name="plazoEntrega", type="integer")
     */
    private $plazoEntrega=15;

    /**
     * @var string
     *
     * @ORM\Column(name="montoTotalCarpinterias", type="decimal", scale=2)
     */
    private $montoTotalCarpinterias=0.00;
	
	/**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="presupuestos")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $cliente;
	
	/**
     * @ORM\OneToMany(targetEntity="Carpinteria", mappedBy="presupuesto")
     */
    protected $carpinterias;
	
	 public function __construct()
    {
        $this->carpinterias = new ArrayCollection();
    }
	
	public function getCarpinterias() {
		return $this->carpinterias;
	}
	
	public function addCarpinterias(Carpinteria $carpinterias) {
		$this->carpinterias[]=$carpinterias;
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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Presupuesto
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set costoEnvio
     *
     * @param string $costoEnvio
     * @return Presupuesto
     */
    public function setCostoEnvio($costoEnvio)
    {
        $this->costoEnvio = $costoEnvio;

        return $this;
    }

    /**
     * Get costoEnvio
     *
     * @return string 
     */
    public function getCostoEnvio()
    {
        return $this->costoEnvio;
    }

    /**
     * Set costoColocacion
     *
     * @param string $costoColocacion
     * @return Presupuesto
     */
    public function setCostoColocacion($costoColocacion)
    {
        $this->costoColocacion = $costoColocacion;

        return $this;
    }

    /**
     * Get costoColocacion
     *
     * @return string 
     */
    public function getCostoColocacion()
    {
        return $this->costoColocacion;
    }

    /**
     * Set plazoEntrega
     *
     * @param integer $plazoEntrega
     * @return Presupuesto
     */
    public function setPlazoEntrega($plazoEntrega)
    {
        $this->plazoEntrega = $plazoEntrega;

        return $this;
    }

    /**
     * Get plazoEntrega
     *
     * @return integer 
     */
    public function getPlazoEntrega()
    {
        return $this->plazoEntrega;
    }

    /**
     * Set montoTotalCarpinterias
     *
     * @param string $montoTotalCarpinterias
     * @return Presupuesto
     */
    public function setMontoTotalCarpinterias($montoTotalCarpinterias)
    {
        $this->montoTotalCarpinterias = $montoTotalCarpinterias;

        return $this;
    }

    /**
     * Get montoTotalCarpinterias
     *
     * @return string 
     */
    public function getMontoTotalCarpinterias()
    {
        return $this->montoTotalCarpinterias;
    }
	
	/**
     * Set cliente
     *
     * @param integer $cliente
     * @return Presupuesto
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
        return $this;
    }
    /**
     * Get cliente
     *
     * @return integer 
     */
    public function getCliente()
    {
        return $this->cliente;
    }

}
