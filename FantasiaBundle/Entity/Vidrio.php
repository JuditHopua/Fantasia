<?php
namespace Acme\FantasiaBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Vidrio
 *
 * @ORM\Table(name="Vidrio")
 * @ORM\Entity
 */
class Vidrio
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
	
    /**
     * @ORM | Column(type="string", length=100)
     */
	protected $tipo;
	
	/**
     * @ORM | Column(type="decimal", scale=2)
     */
	protected $precioxm2;

}