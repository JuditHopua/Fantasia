<?php
namespace Acme\FantasiaBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * AsignacionMarcaModelo
 *
 * @ORM\Table(name="AsignacionMarcaModelo")
 * @ORM\Entity
 */
class AsignacionMarcaModelo
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
	
    /**
     * @ORM | Column(type="decimal", scale=2)
     */
	protected $precioPremarcoML;

	/**
     * @ORM | Column(type="decimal", scale=2)
     */
	protected $precioContramarcoML;
	
	/**
     * @ORM | Column(type="decimal", scale=2)
     */
	protected $precioxML;
	
	/**
     * @ORM | Column(type="text")
     */
	protected $descripcion;
	
	/**
     * @ORM | Column(type="object")
     */
	protected $foto;
	
}