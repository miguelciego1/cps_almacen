<?php
namespace Alm\ControlStockBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Alm\ControlStockBundle\Entity\ControlReactivo;
use Alm\ControlStockBundle\Entity\AlmacenProductoLaboratorio;
use Alm\ControlStockBundle\Entity\Movimiento;
use ALM\ControlStockBundle\Entity\DetalleMovimiento;

class PrePersistListener
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof AlmacenProductoLaboratorio) {
            $entity->setEstado(0);
            $entity->setStock(0);
            $entity->setStockGeneral(0);
        }

        if ($entity instanceof ControlReactivo) {
        	$entity->setActivo(true);
        }

        if ($entity instanceof Movimiento) {
            $entity->setActivo(false);

        }

        if ($entity instanceof DetalleMovimiento) {
            $entity->setActivo(false);
        }
        
    }

    
}

 ?>