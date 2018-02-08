<?php

namespace Alm\ControlStockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


/**
 * LabAlmIngreso
 *
 * @ORM\Table(name="lab_alm_movimiento", uniqueConstraints={@ORM\UniqueConstraint(name="numero_egreso_almacen", columns={"numero_egreso_almacen"})}, indexes={@ORM\Index(name="usuario", columns={"usuario"})})
 * @ORM\Entity
 * @UniqueEntity(
 *     fields={"numeroEgresoAlmacen"},
 *     errorPath="numeroEgresoAlmacen",
 *     message="Este numero de egreso ya existe"
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Movimiento
{

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creado_el", type="datetime", nullable=false)
     */
    private $creadoEl;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_egreso_almacen", type="integer", nullable=true, unique = true)
     */
    private $numeroEgresoAlmacen;


    /**
     * @var string
     *
     * @ORM\Column(name="seccion", type="string", length=1, nullable=false)
     */
    private $seccion;

    /**
     * @var string
     *
     * @ORM\Column(name="recibido_por", type="string", length=50, nullable=false)
     */
    private $recibidoPor;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=1, nullable=false)
     */
    private $tipo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var \Alm\ControlStockBundle\Entity\LabAlmUsuario
     *
     * @ORM\ManyToOne(targetEntity="Alm\ControlStockBundle\Entity\LabAlmUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario", referencedColumnName="id")
     * })
     */
    private $usuario;

    /**
     * @Assert\Valid
     * One Product has Many Features.
     * @ORM\OneToMany(targetEntity="Alm\ControlStockBundle\Entity\DetalleMovimiento", mappedBy="movimiento",cascade={"persist"},orphanRemoval=true)
     */
    private $detalles;
    // ...
    
    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if (is_null($this->getNumeroEgresoAlmacen()) && $this->getTipoAux()=='I') {
            $context->buildViolation('El numero de Egreso es obligatorio para los ingresos')
                ->atPath('numeroEgresoAlmacen')
                ->addViolation();
        }
    }

    public function __construct() {
        $this->detalles = new ArrayCollection();
    }


    /**
     * @ORM\PrePersist
     */
    public function setCreadoEl()
    {
        $this->creadoEl = new \DateTime();

        return $this;
    }

    /**
     * Get creadoEl
     *
     * @return \DateTime 
     */
    public function getCreadoEl()
    {
        return $this->creadoEl;
    }

    /**
     * Set numeroEgresoAlmacen
     *
     * @param integer $numeroEgresoAlmacen
     * @return LabAlmIngreso
     */
    public function setNumeroEgresoAlmacen($numeroEgresoAlmacen)
    {
        $this->numeroEgresoAlmacen = $numeroEgresoAlmacen;

        return $this;
    }

    /**
     * Get numeroEgresoAlmacen
     *
     * @return integer 
     */
    public function getNumeroEgresoAlmacen()
    {
        return $this->numeroEgresoAlmacen;
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
     * Set usuario
     *
     * @param \Alm\ControlStockBundle\Entity\LabAlmUsuario $usuario
     * @return LabAlmIngreso
     */
    public function setUsuario(\Alm\ControlStockBundle\Entity\LabAlmUsuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Alm\ControlStockBundle\Entity\LabAlmUsuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Add detalles
     *
     * @param \Alm\ControlStockBundle\Entity\LabAlmIngreso $detalles
     * @return LabAlmIngreso
     */
    public function addDetalle(\Alm\ControlStockBundle\Entity\DetalleMovimiento $detalles)
    {
        $detalles->setMovimiento($this);
        $this->detalles[] = $detalles;

        return $this;
    }

    /**
     * Remove detalles
     *
     * @param \Alm\ControlStockBundle\Entity\LabAlmIngreso $detalles
     */
    public function removeDetalle(\Alm\ControlStockBundle\Entity\DetalleMovimiento $detalles)
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
     * Set activo
     *
     * @param boolean $activo
     * @return LabAlmIngreso
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
     * Set tipo
     *
     * @param string $tipo
     * @return LabAlmIngreso
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }
    
    public function setTipoAux($tipo)
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
                return 'Ingreso';
                break;
            
            case 'E':
                return 'Egreso';
                break;

            case 'G':
                return 'Ingreso General';
                break;
        }
    }

    public function getTipoAux()
    {
        return $this->tipo;
    }

    /**
     * Set seccion
     *
     * @param string $seccion
     * @return Movimiento
     */
    public function setSeccion($seccion)
    {
        $this->seccion = $seccion;

        return $this;
    }
    
    public function setSeccionAux($seccion)
    {
        $this->seccion = $seccion;

        return $this;
    }

    /**
     * Get seccion
     *
     * @return string 
     */
    public function getSeccion()
    {
        switch ($this->seccion){
            case 'C':
                return 'Central';
                break;
            case 'H':
                return 'Hormonas';
                break;

            case 'P':
                return 'Parasitologia';
                break;

            case 'S':
                return 'Serologia';
                break;

            case 'Q':
                return 'Quimica';
                break;

            case 'M':
                return 'Hematologia';
                break;

            case 'U':
                return 'Urianalisis';
                break;

            case 'B':
                return 'Bacteriologia';
                break;

        }
    }

    public function getSeccionAux()
    {
        return $this->seccion;
    }

    /**
     * Set recibidoPor
     *
     * @param string $recibidoPor
     * @return Movimiento
     */
    public function setRecibidoPor($recibidoPor)
    {
        $this->recibidoPor = $recibidoPor;

        return $this;
    }

    /**
     * Get recibidoPor
     *
     * @return string 
     */
    public function getRecibidoPor()
    {
        return $this->recibidoPor;
    }
}
