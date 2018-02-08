<?php

namespace Alm\ControlStockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * LabAlmControl
 *
 * @ORM\Table(name="lab_alm_control")
 * @ORM\Entity
 * @UniqueEntity(
 *     fields={"productolab","lote","vencimiento","marca"},
 *     errorPath="productolab",
 *     message="Ya existe un Control de Reactivo con estos parametros"
 * )
 */
class ControlReactivo
{
   
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer" , length=11)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="lote", type="string", length=20, nullable=false)
     */
    private $lote;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="vencimiento", type="date", nullable=false)
     */
    private $vencimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="marca", type="string", length=50, nullable=false)
     */
    private $marca;

   

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var \Alm\ControlStockBundle\Entity\LabAlmProductolab
     *
     * @ORM\ManyToOne(targetEntity="Alm\ControlStockBundle\Entity\AlmacenProductoLaboratorio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="productoLab_id", referencedColumnName="id")
     * })
     */
    private $productolab;

    // public function __toString(){
    //     return $this->getCadena();
    // }

    // public function getCadena()
    // {
    //     return $this->getVencimiento()->format('d-m-Y').'|'.$this->getLote().'|'.$this->getMarca();
    // }


    // public function __toString()
    // {
    //     $fechaV=$this->getVencimiento()->format('d-m-Y');
    //     return $this->getProductolab().'--'.$this->getLote().'--'.$this->getVencimiento()->format('d-m-Y').'--'.$this->getMarca() ?: '';
    // }

    public  function string()
    {
        return $this->getProductolab()->getProducto()->getNombre().'--'.$this->getLote().'--'.$this->getVencimiento()->format('d-m-Y').'--'.$this->getMarca() ?: '';
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
     * Set lote
     *
     * @param string $lote
     * @return LabAlmControl
     */
    public function setLote($lote)
    {
        $this->lote = $lote;

        return $this;
    }

    /**
     * Get lote
     *
     * @return string 
     */
    public function getLote()
    {
        return $this->lote;
    }

    /**
     * Set vencimiento
     *
     * @param \DateTime $vencimiento
     * @return LabAlmControl
     */
    public function setVencimiento($vencimiento)
    {
        $this->vencimiento = $vencimiento;

        return $this;
    }

    /**
     * Get vencimiento
     *
     * @return \DateTime 
     */
    public function getVencimiento()
    {
        return $this->vencimiento;
    }

    /**
     * Set marca
     *
     * @param string $marca
     * @return LabAlmControl
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return string 
     */
    public function getMarca()
    {
        return $this->marca;
    }

    

    /**
     * Set productolab
     *
     * @param \Alm\ControlStockBundle\Entity\AlmacenProductoLaboratorio $productolab
     * @return ControlReactivo
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

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return ControlReactivo
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
}
