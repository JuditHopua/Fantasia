<?php
namespace Acme\FantasiaBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Carpinteria
 *
 * @ORM\Table(name="Carpinteria")
 * @ORM\Entity
 */
class Carpinteria
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
	protected $alto;
	
	/**
     * @ORM | Column(type="decimal", scale=2)
     */
	protected $ancho;
	
	/**
     * @ORM | Column(type="boolean")
     */
	protected $premarco;
	
	/**
     * @ORM | Column(type="boolean")
     */
	protected $contramarco;
	
	/**
     * @ORM | Column(type="integer")
     */
	protected $cantidad;

}