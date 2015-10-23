<?php

namespace Acme\FantasiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cliente
 *
 * @ORM\Table(name = "cliente")
 * @ORM\Entity
 */
class Cliente
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
     * @ORM\Column(name="nombre", type="string", length=50)
	 * @ORM\nombre
     */
    protected $nombre;
	
	 /**
	 * @var string
	 *
     * @ORM\Column(name="apellido", type="string", length=50)
	 * @ORM\apellido
     */
    protected $apellido;
	
	 /**
	 * @var string
	 *
     * @ORM\Column(name="email", type="string", length=50)
	 * @ORM\email
     */
    protected $email;
	
	/**
     * @var integer
     *
     * @ORM\Column(name="telefono", type="integer")
     * @ORM\telefono
     */
    protected $telefono;

	 /**
	 * @var string
	 *
     * @ORM\Column(name="domicilio", type="string", length=100)
	 * @ORM\domicilio
     */
    protected $domicilio;
	
	 /**
	 * @var string
	 *
     * @ORM\Column(name="oservaciones", type="string", length=100)
	 * @ORM\observaciones
     */
    protected $observaciones;
	
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
