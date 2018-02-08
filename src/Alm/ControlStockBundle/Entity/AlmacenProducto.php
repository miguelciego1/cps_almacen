<?php

namespace Alm\ControlStockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Alm\ControlStockBundle\Entity\AlmacenProductoLaboratorio;

/**
 * AlmAdmProducto
 *
 * @ORM\Table(name="alm_adm_producto", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_7115BBB43C3C1592", columns={"codPro"})})
 * @ORM\Entity(repositoryClass="Alm\ControlStockBundle\Repository\AlmAdmProductoRepository")
 */
class AlmacenProducto
{
    /**
     * @var string
     *
     * @ORM\Column(name="cod_prod", type="string", length=12, nullable=false)
     */
    private $codpro;


    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=65, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="unidad", type="string", length=15, nullable=false)
     */
    private $unimedida;

    /**
     * @var string
     *
     * @ORM\Column(name="prioridad", type="string", length=1, nullable=true)
     */
    private $prioridad;

    /**
     * @var string
     *
     * @ORM\Column(name="activo", type="string", length=1, nullable=false)
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
     * One Customer has One Cart.
     * @ORM\OneToOne(targetEntity="AlmacenProductoLaboratorio", mappedBy="producto")
     */
    private $productolab;

   
    

    public function __toString()
    {
        return $this->getNombre() ?: ' ';
    }

    

    /**
     * Set codpro
     *
     * @param string $codpro
     * @return AlmacenProducto
     */
    public function setCodpro($codpro)
    {
        $this->codpro = $codpro;

        return $this;
    }

    /**
     * Get codpro
     *
     * @return string 
     */
    public function getCodpro()
    {
        return $this->codpro;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return AlmacenProducto
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set unimedida
     *
     * @param string $unimedida
     * @return AlmacenProducto
     */
    public function setUnimedida($unimedida)
    {
        $this->unimedida = $unimedida;

        return $this;
    }

    /**
     * Get unimedida
     *
     * @return string 
     */
    public function getUnimedida()
    {
        return $this->unimedida;
    }

    /**
     * Set prioridad
     *
     * @param string $prioridad
     * @return AlmacenProducto
     */
    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;

        return $this;
    }

    /**
     * Get prioridad
     *
     * @return string 
     */
    public function getPrioridad()
    {
        return $this->prioridad;
    }

    /**
     * Set activo
     *
     * @param string $activo
     * @return AlmacenProducto
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return string 
     */
    public function getActivo()
    {
        return $this->activo;
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
     * Set productolab
     *
     * @param \Alm\ControlStockBundle\Entity\AlmacenProductoLaboratorio $productolab
     * @return AlmacenProducto
     */
    public function setProductolab(\Alm\ControlStockBundle\Entity\AlmacenProductoLaboratorio $productolab = null)
    {
        $this->productolab = $productolab;

        return $this;
    }

    /**
     * Get productolab
     *
     * @return \Alm\ControlStockBundle\Entity\AlmacenProductoLaboratorio 
     */
    public function getProductolab()
    {
        return $this->productolab;
    }
}
