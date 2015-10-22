<?php

namespace Acme\FantasiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vidrio
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Vidrio
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
