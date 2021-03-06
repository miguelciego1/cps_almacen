<?php

namespace Alm\ControlStockBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ProductoLabRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LabAlmProductolabRepository extends EntityRepository
{
  public function findAjaxValue($term,$v){
      $em = $this->getEntityManager();
      $term = str_replace(' ', '%', $term);
      switch ($v) {
        case 1:
          $consul = $em->createQuery('SELECT p
                                  FROM AlmControlStockBundle:LabAlmProductolab p
                                  JOIN p.producto pr 
                                  WHERE p.producto=pr.id AND p.stock > 0 AND pr.nombre LIKE \'%'.$term.'%\' 
                               ');
          break;
        
        default:
          $consul = $em->createQuery('SELECT p
                                  FROM AlmControlStockBundle:LabAlmProductolab p
                                  JOIN p.producto pr 
                                  WHERE p.producto=pr.id AND pr.nombre LIKE \'%'.$term.'%\' 
                               ');
          break;
      }
      
      $resp = $consul->getResult();
      return $resp;
  }

  public function findByProductoId($productoId)
  {
    $em = $this->getEntityManager();
    $consul = $em->createQuery('SELECT p
                                FROM AlmControlStockBundle:ProductoLab p
                                WHERE p.id=:productoId
                                ')->setParameter('productoId',$productoId)->setMaxResults(1);
    $resp = $consul->getOneOrNullResult();
    return $resp;
  }
  public function findOneByProductoCodigo($productoId)
  {
    $em = $this->getEntityManager();
    $consul = $em->createQuery('SELECT p
                                FROM AlmControlStockBundle:LabAlmProductolab p JOIN p.producto pr
                                WHERE pr.codpro=:productoId
                                ')->setParameter('productoId',$productoId)->setMaxResults(1);
    $resp = $consul->getOneOrNullResult();
    return $resp;
  }
  public function findByEstadoPersonalizado($estado)
  {
    $em = $this->getEntityManager();
    if ($estado=='1' || $estado=='0') {
      $consul = $em->createQuery('SELECT p
                                  FROM AlmControlStockBundle:LabAlmProductolab p 
                                  WHERE p.estado LIKE :estado
                               ')->setParameter('estado',$estado);
    }elseif ($estado=='2') {
      $consul = $em->createQuery('SELECT p
                                  FROM AlmControlStockBundle:LabAlmProductolab p
                                  WHERE p.stock>0
                               ');
    }else{
      $consul = $em->createQuery('SELECT p
                                  FROM AlmControlStockBundle:LabAlmProductolab p
                               ');
    }
    $resp = $consul->getResult();
      return $resp;
   
  }
}
