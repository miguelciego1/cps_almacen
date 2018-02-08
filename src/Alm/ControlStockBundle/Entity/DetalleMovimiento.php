<?php

namespace Alm\ControlStockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * DetalleMovimiento
 *
 * @ORM\Table(name="lab_alm_detalle_movimiento", indexes={@ORM\Index(name="movimiento_id", columns={"movimiento_id"}), @ORM\Index(name="productoLab_id", columns={"productoLab_id"})},uniqueConstraints={@ORM\UniqueConstraint(name="unique_idx", columns={"productoLab_id", "movimiento_id"})})
 * @ORM\Entity(repositoryClass="Alm\ControlStockBundle\Repository\LabAlmDetalleingresoRepository")
 * @UniqueEntity(
 *     fields={"productolab", "movimiento"},
 *     errorPath="productolab",
 *     message="Este ingreso ya tiene este producto"
 * )
 */
class DetalleMovimiento
{
    /**
     * @var integer
     * @Assert\NotBlank()
     * @Assert\GreaterThan(value=0)
     * @ORM\Column(name="cantidad", type="integer", nullable=false)
     */
    private $cantidad;

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
     * @var \Alm\ControlStockBundle\Entity\LabAlmProductolab
     *
     * @ORM\ManyToOne(targetEntity="Alm\ControlStockBundle\Entity\AlmacenProductoLaboratorio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="productoLab_id", referencedColumnName="id")
     * })
     */
    private $productolab;

    /**
     * @var \Alm\ControlStockBundle\Entity\Movimiento
     *
     * @ORM\ManyToOne(targetEntity="Alm\ControlStockBundle\Entity\Movimiento", inversedBy="detalles")
     * @ORM\JoinColumn(name="movimiento_id", referencedColumnName="id",onDelete="CASCADE")
     * 
     */
    private $movimiento;

    /**
     * @Assert\Valid
     * One Product has Many Features.
     * @ORM\OneToMany(targetEntity="Alm\ControlStockBundle\Entity\DetalleControl", mappedBy="detalleMovimiento",cascade={"persist"},orphanRemoval=true)
     */
    private $detalles;

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->getCantidad()>$this->getProductolab()->getStock() && $this->getMovimiento()->getTipoAux()=='E') {
            $context->buildViolation('No tiene suficiente cantidad en su almacen de este producto')
                ->atPath('cantidad')
                ->addViolation();
        }
    }


    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return DetalleMovimiento
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
     * Set estado
     *
     * @param string $estado
     * @return DetalleMovimiento
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
     * Constructor
     */
    public function __construct()
    {
        $this->detalles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add detalles
     *
     * @param \Alm\ControlStockBundle\Entity\DetalleControl $detalles
     * @return DetalleMovimiento
     */
    public function addDetalle(\Alm\ControlStockBundle\Entity\DetalleControl $detalles)
    {
        $detalles->setDetalleMovimiento($this);
        $this->detalles[] = $detalles;

        return $this;
    }

    /**
     * Remove detalles
     *
     * @param \Alm\ControlStockBundle\Entity\DetalleControl $detalles
     */
    public function removeDetalle(\Alm\ControlStockBundle\Entity\DetalleControl $detalles)
    {
        $this->detalles->removeElement($detalles);
    }

    /**
     * Get detalles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDetalles()
    {
        return $this->detalles;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return DetalleMovimiento
     */
    public function setTipo()
    {
        if ($this->getIngreso() instanceof Alm\ControlStockBundle\Entity\LabAlmIngreso) {
                $tipo='I';
            }
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
        return $this->tipo;
    }

    /**
     * Set productolab
     *
     * @param \Alm\ControlStockBundle\Entity\AlmacenProductoLaboratorio $productolab
     * @return DetalleMovimiento
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
     * Set movimiento
     *
     * @param \Alm\ControlStockBundle\Entity\Movimiento $movimiento
     * @return DetalleMovimiento
     */
    public function setMovimiento(\Alm\ControlStockBundle\Entity\Movimiento $movimiento = null)
    {
        $this->movimiento = $movimiento;

        return $this;
    }

    /**
     * Get movimiento
     *
     * @return \Alm\ControlStockBundle\Entity\Movimiento 
     */
    public function getMovimiento()
    {
        return $this->movimiento;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return DetalleMovimiento
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
