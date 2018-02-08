<?php

namespace Alm\ControlStockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * LabAlmProductolab
 *
 * @ORM\Table(name="lab_alm_productolab", indexes={@ORM\Index(name="producto_id", columns={"producto_id"})})
 * @ORM\Entity(repositoryClass="Alm\ControlStockBundle\Repository\LabAlmProductolabRepository")
 * @UniqueEntity(
 *     fields={"producto"},
 *     errorPath="producto",
 *     message="Este producto ya existe"
 * )
 */
class AlmacenProductoLaboratorio
{
    /**
     * @var integer
     *
     * @ORM\Column(name="stock", type="integer",nullable=true, options={"unsigned":true,"default":0})
     */
    private $stock;

    /**
     * @var integer
     *
     * @ORM\Column(name="stock_general", type="integer",nullable=true, options={"unsigned":true,"default":0})
     */
    private $stockGeneral;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=1, nullable=false)
     */
    private $tipo;

    /**
     * @var integer
     * @Assert\NotBlank()
     * @ORM\Column(name="minimo", type="integer", nullable=true)
     */
    private $minimo;

    /**
     * @var string
     *
     * @ORM\Column(name="presentacion", type="string", length=50, nullable=true)
     */
    private $presentacion;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=1, nullable=true, options={"default":"0"})
     */
    private $estado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Alm\ControlStockBundle\Entity\AlmacenProducto
     *
     * @ORM\OneToOne(targetEntity="Alm\ControlStockBundle\Entity\AlmacenProducto" , inversedBy="productolab")
     * @ORM\JoinColumn(name="producto_id", referencedColumnName="id" )
     */
    private $producto;

    // public function __toString()
    // {
    //     return $this->getId() ?: '';
    // }


    /**
     * Set tipo
     *
     * @param string $tipo
     * @return LabAlmProductolab
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        switch ($this->tipo) {
            case 'I':
                return 'Insumo';
                break;
            
            case 'R':
                return 'Reactivo';
                break;
        }


    }

    public function getTipoAux()
    {
       return $this->tipo;

    }

    /**
     * Set minimo
     *
     * @param integer $minimo
     * @return LabAlmProductolab
     */
    public function setMinimo($minimo)
    {
        $this->minimo = $minimo;

        return $this;
    }

    /**
     * Get minimo
     *
     * @return integer 
     */
    public function getMinimo()
    {
        return $this->minimo;
    }

    /**
     * Set presentacion
     *
     * @param string $presentacion
     * @return LabAlmProductolab
     */
    public function setPresentacion($presentacion)
    {
        $this->presentacion = $presentacion;

        return $this;
    }

    /**
     * Get presentacion
     *
     * @return string 
     */
    public function getPresentacion()
    {
        return $this->presentacion;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return LabAlmProductolab
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
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
     * Set stock
     *
     * @param integer $stock
     * @return LabAlmProductolab
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return integer 
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return LabAlmProductolab
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean 
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set producto
     *
     * @param \Alm\ControlStockBundle\Entity\AlmacenProducto $producto
     * @return AlmacenProductoLaboratorio
     */
    public function setProducto(\Alm\ControlStockBundle\Entity\AlmacenProducto $producto = null)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto
     *
     * @return \Alm\ControlStockBundle\Entity\AlmacenProducto 
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set stockGeneral
     *
     * @param integer $stockGeneral
     * @return AlmacenProductoLaboratorio
     */
    public function setStockGeneral($stockGeneral)
    {
        $this->stockGeneral = $stockGeneral;

        return $this;
    }

    /**
     * Get stockGeneral
     *
     * @return integer 
     */
    public function getStockGeneral()
    {
        return $this->stockGeneral;
    }
}
