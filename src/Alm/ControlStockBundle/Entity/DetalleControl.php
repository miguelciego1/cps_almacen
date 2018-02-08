<?php

namespace Alm\ControlStockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * DetalleControl
 *
 * @ORM\Table(name="lab_alm_detalle_control", indexes={@ORM\Index(name="control_id", columns={"control_id"}), @ORM\Index(name="detalle_movimiento_id", columns={"detalle_movimiento_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class DetalleControl
{
    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=false)
     */
    private $cantidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="saldo", type="integer", nullable=false)
     */
    private $saldo;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Alm\ControlStockBundle\Entity\DetalleMovimiento
     *
     * @ORM\ManyToOne(targetEntity="Alm\ControlStockBundle\Entity\DetalleMovimiento", inversedBy="detalles")
     * @ORM\JoinColumn(name="detalle_movimiento_id", referencedColumnName="id",onDelete="CASCADE")
     *
     */
    private $detalleMovimiento;

    /**
     * @var \Alm\ControlStockBundle\Entity\LabAlmControl
     *
     * @ORM\ManyToOne(targetEntity="Alm\ControlStockBundle\Entity\ControlReactivo")
     * @ORM\JoinColumn(name="control_id", referencedColumnName="id")
     *
     */
    private $control;


    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->getControl()->getProductolab()!=$this->getDetalleMovimiento()->getProductolab()) {
            $context->buildViolation('Este control no pretenece al mismo producto')
                ->atPath('control')
                ->addViolation();
        }
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return DetalleControl
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
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
     * Set control
     *
     * @param \Alm\ControlStockBundle\Entity\ControlReactivo $control
     * @return DetalleControl
     */
    public function setControl(\Alm\ControlStockBundle\Entity\ControlReactivo $control = null)
    {
        $this->control = $control;

        return $this;
    }

    /**
     * Get control
     *
     * @return \Alm\ControlStockBundle\Entity\ControlReactivo 
     */
    public function getControl()
    {
        return $this->control;
    }

    /**
     * Set detalleMovimiento
     *
     * @param \Alm\ControlStockBundle\Entity\DetalleMovimiento $detalleMovimiento
     * @return DetalleControl
     */
    public function setDetalleMovimiento(\Alm\ControlStockBundle\Entity\DetalleMovimiento $detalleMovimiento = null)
    {
        $this->detalleMovimiento = $detalleMovimiento;

        return $this;
    }

    /**
     * Get detalleMovimiento
     *
     * @return \Alm\ControlStockBundle\Entity\DetalleMovimiento 
     */
    public function getDetalleMovimiento()
    {
        return $this->detalleMovimiento;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setSaldo()
    {
        $saldo=$this->getControl()->getProductolab()->getStock();
        $this->saldo = $saldo;

        return $this;
    }

    /**
     * Get saldo
     *
     * @return integer 
     */
    public function getSaldo()
    {
        return $this->saldo;
    }
}
