<?php

namespace HL\FantasiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use HL\FantasiaBundle\Entity\Cliente;
use HL\FantasiaBundle\Entity\User;


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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="costoEnvio", type="decimal", scale=2)
     */
    private $costoEnvio;

    /**
     * @var string
     *
     * @ORM\Column(name="costoColocacion", type="decimal", scale=2)
     */
    private $costoColocacion;

    /**
     * @var integer
     *
     * @ORM\Column(name="plazoEntrega", type="integer")
     */
    private $plazoEntrega;

    /**
     * @var string
     *
     * @ORM\Column(name="montoTotalCarpinterias", type="decimal", scale=2)
     */
    private $montoTotalCarpinterias;
	
	/**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="presupuestos")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     */
    protected $cliente;
	
	/**
     * @ORM\OneToMany(targetEntity="Carpinteria", mappedBy="presupuesto")
     */
    protected $carpinterias;
	
	/**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="presupuestos")
	 * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
	 */
    protected $usuario;
	
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
     * @return Cliente
     */
    public function setCliente(Cliente $cliente)
    {
        $this->cliente = $cliente;
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

	/**
     * Set usuario
     *
     * @param integer $usuario
     * @return User
     */
    public function setUser(User $usuario)
    {
        $this->usuario = $usuario;
    }
    /**
     * Get usuario
     *
     * @return integer 
     */
    public function getUser()
    {
        return $this->usuario;
    }
}
