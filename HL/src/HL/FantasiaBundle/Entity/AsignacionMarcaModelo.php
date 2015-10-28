<?php

namespace HL\FantasiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var \stdClass
     *
     * @ORM\Column(name="foto", type="object")
     */
    private $foto;


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
     *
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
     *
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
     *
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
     *
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
     * Set foto
     *
     * @param \stdClass $foto
     *
     * @return AsignacionMarcaModelo
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return \stdClass
     */
    public function getFoto()
    {
        return $this->foto;
    }
}

