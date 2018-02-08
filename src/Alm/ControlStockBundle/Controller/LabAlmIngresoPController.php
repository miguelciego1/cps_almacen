<?php

namespace Alm\ControlStockBundle\Controller;

use Alm\ControlStockBundle\Entity\Movimiento;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class LabAlmIngresoPController extends Controller
{   

    public function confirmarAction($id){
        $labAlmIngreso = $this->admin->getSubject();
        $em=$this->getDoctrine()->getManager();

        if ($labAlmIngreso->getActivo()) {
            $this->addFlash('sonata_flash_error', 'Ya esta confirmado este movimiento');
            return new RedirectResponse($this->admin->generateUrl('list'));
        }
        if (count($labAlmIngreso->getDetalles())<1) {
            $this->addFlash('sonata_flash_error', 'No tiene productos registrados');
            return new RedirectResponse($this->admin->generateUrl('list'));
        }
        
        $ingresoDetalles=$labAlmIngreso->getDetalles();
        $labAlmIngreso->setActivo(true);
       
        foreach ($ingresoDetalles as $ingresoDetalle) {

                $ingresoDetalle->setActivo(true);
                $productolab=$ingresoDetalle->getProductolab();
                $ig=false;// sirve para que salte la validacion de control de ractivos eningresos generales
                switch ($labAlmIngreso->getTipoAux()) {
                    case 'I':
                        $productolab->setStock($productolab->getStock()+$ingresoDetalle->getCantidad());
                        $productolab->setStockGeneral($productolab->getStockGeneral()-$ingresoDetalle->getCantidad());
                        $productolab->setActivo(true);
                        $ig=true;
                        break;
                    
                    case 'E':
                        $productolab->setStock($productolab->getStock()-$ingresoDetalle->getCantidad());
                        $ig=true;
                        break;

                    case 'G':
                        $productolab->setStockGeneral($productolab->getStockGeneral()+$ingresoDetalle->getCantidad());
                        break;
                }
                    

                if ($productolab->getTipoAux()=='R' && $ig) {
                        $detalles=$ingresoDetalle->getDetalles();
                        if (count($detalles)<1) {
                            $this->addFlash('sonata_flash_error', 'No tiene registro de controles para reactivos');
                            return new RedirectResponse($this->admin->generateUrl('list'));
                        }else{
                            $verifi=0;
                            foreach ($detalles as $detalle) {
                                $verifi=$verifi+$detalle->getCantidad();
                            }
                            if ($ingresoDetalle->getCantidad()!=$verifi) {
                                $this->addFlash('sonata_flash_error', 'Los controles del reactivo '.' " '.$productolab->getProducto()->getNombre().' " '.'no estan bien');
                                return new RedirectResponse($this->admin->generateUrl('list'));
                            }

                        }


                        
                }

                if ($productolab->getStock()>0 && $productolab->getStock()<=$productolab->getMinimo()) 
                    {
                        $productolab->setEstado('1');
                    }elseif ($productolab->getStock()>$productolab->getMinimo()) {
                        $productolab->setEstado('2');
                    }else{
                        $productolab->setEstado('0');
                    }
                
                $em->persist($productolab);
                $em->persist($ingresoDetalle);
            
        }
        $em->persist($labAlmIngreso);
        $em->flush();
        $this->addFlash('sonata_flash_success', 'El movimiento con '.$id.' se confirmo correctamente');
            return new RedirectResponse($this->admin->generateUrl('list'));
    }

    public function preEdit(Request $request,$object){
        if ($object->getActivo()) {
            $this->addFlash('sonata_flash_error', 'Este movimiento no puede ser modificado');
            return new RedirectResponse($this->admin->generateUrl('list'));
        }
        
    }
}
