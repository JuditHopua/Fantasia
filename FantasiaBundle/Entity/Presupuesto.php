<?php
namespace Acme\FantasiaBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Presupuesto
 *
 * @ORM\Table(name="Presupuesto")
 * @ORM\Entity
 */
class Prespuesto
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
	
    /**
     * @ORM | Column(type="date")
     */
	protected $fecha;
	
	/**
     * @ORM | Column(type="decimal", scale=2)
     */
	protected $costoEnvio;
	
	/**
     * @ORM | Column(type="decimal", scale=2)
     */
	protected $costoColocacion;
	
	/**
     * @ORM | Column(type="integer")
     */
	protected $plazoEntrega;
	
	/**
     * @ORM | Column(type="decimal", scale=2)
     */
	protected $montoTotalCarpinterias;
	
}