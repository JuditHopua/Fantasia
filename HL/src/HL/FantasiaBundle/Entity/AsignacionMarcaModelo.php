<?php

namespace HL\FantasiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use HL\FantasiaBundle\Entity\Modelo;
use HL\FantasiaBundle\Entity\Marca;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AsignacionMarcaModelo
 *
 * @ORM\Table(name="AsignacionMarcaModelo")
 * @ORM\Entity(repositoryClass="HL\FantasiaBundle\Entity\AsignacionMarcaModeloRepository")
 */
class AsignacionMarcaModelo
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
     * @ORM\Column(name="precioPremarcoML", type="decimal", scale=2)
     */
    private $precioPremarcoML;

    /**
     * @var string
     *
     * @ORM\Column(name="precioContramarcoML", type="decimal", scale=2)
     */
    private $precioContramarcoML;

    /**
     * @var string
     *
     * @ORM\Column(name="precioxML", type="decimal", scale=2)
     */
    private $precioxML;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;
	
	 /**
	* @ORM\Column(type="string", length=255, nullable=true)
	*/
	public $path;
	
	 /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

	/**
     * @ORM\OneToMany(targetEntity="Carpinteria", mappedBy="asignacion")
     */
    protected $carpinterias;
	
	/**
     * @ORM\ManyToOne(targetEntity="Modelo", inversedBy="asignaciones")
     * @ORM\JoinColumn(name="modelo_id", referencedColumnName="id")
     */
    protected $modelo;
	
	/**
     * @ORM\ManyToOne(targetEntity="Marca", inversedBy="asignaciones")
	  * @ORM\JoinColumn(name="marca_id", referencedColumnName="id")
     */
    protected $marca;
 
	/**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
	
	public function getAbsolutePath()
	{
		return null === $this->path
		? null
		: $this->getUploadRootDir().’/’.$this->path;
	}
		
	public function getWebPath()
	{
		return null === $this->path
		? null 
		: $this->getUploadDir().'/'.$this->path;
	}
			
	protected function getUploadRootDir()
	{
		// la ruta absoluta al directorio donde se deben guardar los documentos cargados
		return __DIR__.'/../../../../web/'.$this->getUploadDir();
	}
	
	protected function getUploadDir()
	{
		//se libera del __DIR__ para no desviarse al mostrar 'doc/image' en la vista.
		return 'bundles/fantasia/images';
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
     * Set precioPremarcoML
     *
     * @param string $precioPremarcoML
     * @return AsignacionMarcaModelo
     */
    public function setPrecioPremarcoML($precioPremarcoML)
    {
        $this->precioPremarcoML = $precioPremarcoML;

        return $this;
    }

    /**
     * Get precioPremarcoML
     *
     * @return string 
     */
    public function getPrecioPremarcoML()
    {
        return $this->precioPremarcoML;
    }

    /**
     * Set precioContramarcoML
     *
     * @param string $precioContramarcoML
     * @return AsignacionMarcaModelo
     */
    public function setPrecioContramarcoML($precioContramarcoML)
    {
        $this->precioContramarcoML = $precioContramarcoML;

        return $this;
    }

    /**
     * Get precioContramarcoML
     *
     * @return string 
     */
    public function getPrecioContramarcoML()
    {
        return $this->precioContramarcoML;
    }

    /**
     * Set precioxML
     *
     * @param string $precioxML
     * @return AsignacionMarcaModelo
     */
    public function setPrecioxML($precioxML)
    {
        $this->precioxML = $precioxML;

        return $this;
    }

    /**
     * Get precioxML
     *
     * @return string 
     */
    public function getPrecioxML()
    {
        return $this->precioxML;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return AsignacionMarcaModelo
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
	
	/**
     * Set modelo
     *
     * @param integer $modelo
     * @return Modelo
     */
    public function setModelo(Modelo $modelo)
    {
        $this->modelo = $modelo;
    }
    /**
     * Get modelo
     *
     * @return integer 
     */
    public function getModelo()
    {
        return $this->modelo;
    }
	
	/**
     * Set marca
     *
     * @param integer $marca
     * @return Marca
     */
    public function setMarca(Marca $marca)
    {
        $this->marca = $marca;
    }
    /**
     * Get marca
     *
     * @return integer 
     */
    public function getMarca()
    {
        return $this->marca;
    }
	
	public function upload()
    {  
		 // the file property can be empty if the field is not required
    if (null === $this->getFile()) {
        return;
    }

    // aquí usa el nombre de archivo original pero lo debes
    // sanear al menos para evitar cualquier problema de seguridad

    // move takes the target directory and then the
    // target filename to move to
    $this->getFile()->move(
        $this->getUploadRootDir(),
        $this->getFile()->getClientOriginalName()
    );

    // set the path property to the filename where you've saved the file
    $this->path = $this->getFile()->getClientOriginalName();

    // limpia la propiedad «file» ya que no la necesitas más
    $this->file = null;
	}

    public function __construct()
    {
        $this->carpinterias = new ArrayCollection();
    }	

    public function getCarpinterias() {
        return $this->carpinterias;
    }

    public function addCarpinterias(Carpinteria $carpinterias) {
        $this->carpinterias[]=$carpinterias;}
 
}
