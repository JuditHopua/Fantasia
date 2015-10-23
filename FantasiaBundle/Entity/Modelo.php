<?php
namespace Acme\FantasiaBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Modelo
 *
 * @ORM\Table(name="Modelo")
 * @ORM\Entity
 */
class Modelo
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
	protected $nombre;

}