<?php

namespace HL\FantasiaBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="HL\FantasiaBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
	 /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
	 * @Assert\NotBlank(message="Por favor ingrese su numbre", groups={"Registration", "Profile"})
     */
    private $nombre;
	
	 /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=100)
	 * @Assert\NotBlank(message="Por favor ingrese su apellido", groups={"Registration", "Profile"})
     */
    private $apellido;

    /**
     * @var integer
     *
     * @ORM\Column(name="dni", type="integer")
     * @Assert\NotBlank(message="Por favor ingrese su dni", groups={"Registration", "Profile"})
	 */
    private $dni;

	 /**
     * @ORM\OneToMany(targetEntity="Presupuesto", mappedBy="usuario")
     */
    protected $presupuestos;
	
	 //public function __construct()
    //{
        //$this->presupuestos = new ArrayCollection();
	//}	
	
	public function getPresupuestos() {
		return $this->presupuestos;
	}
	
	public function addPresupuestos(HL\FantasiaBundle\Entity\Presupuesto $presupuestos) {
		$this->presupuestos[]=$presupuestos;
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
     * Set nombre
     *
     * @param string $nombre 
     * 
     * @return User
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

	  /**
     * Set apellido
     *
     * @param string $apellido
	 * 
	 * @return User
     */
    public function setApellido($apellido)
    {
		$this->apellido = $apellido;
        return $this;
    }
	
	  /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }
	
	  /**
     * Set dni
     *
     * @param integer $dni
	 * 
	 * @return User
     */
    public function setDni($dni)
    {
		$this->dni = $dni;
        return $this;
    }
	
	  /**
     * Get dni
     *
     * @return integer 
     */
    public function getDni()
    {
        return $this->dni;
    }
		
	public function _construct(){
		parent::_construct();
	}
		
}
