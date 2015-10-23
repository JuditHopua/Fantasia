<?php
namespace Acme\FantasiaBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Marca
 *
 * @ORM\Table(name="Marca")
 * @ORM\Entity
 */
class Marca
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