<?php

namespace Alm\ControlStockBundle\Controller;

use Alm\ControlStockBundle\Entity\LabAlmIngreso;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Labalmingreso controller.
 *
 * @Route("labalmingreso")
 */
class LabAlmIngresoController extends Controller
{
    /**
     * Lists all labAlmIngreso entities.
     *
     * @Route("/", name="labalmingreso_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $labAlmIngresos = $em->getRepository('AlmControlStockBundle:LabAlmIngreso')->findAll();

        return $this->render('labalmingreso/index.html.twig', array(
            'labAlmIngresos' => $labAlmIngresos,
        ));
    }

    /**
     * Creates a new labAlmIngreso entity.
     *
     * @Route("/new", name="labalmingreso_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $labAlmIngreso = new Labalmingreso();
        $form = $this->createForm('Alm\ControlStockBundle\Form\LabAlmIngresoType', $labAlmIngreso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $labAlmIngreso->setUsuario($this->getUser());
            $labAlmIngreso->setEstado(1);
            $em->persist($labAlmIngreso);
            $em->flush($labAlmIngreso);
            $this->get('ras_flash_alert.alert_reporter')->addSuccess("Datos Generales Guardados");

            return $this->redirectToRoute('labalmdetalleingreso_new', array('id' => $labAlmIngreso->getId()));
        }

        return $this->render('labalmingreso/new.html.twig', array(
            'labAlmIngreso' => $labAlmIngreso,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a labAlmIngreso entity.
     *
     * @Route("/{id}/confirmar/", name="labalmingreso_confirmar")
     * @Method("GET")
     */
    public function confirmarAction(LabAlmIngreso $labAlmIngreso)
    {
        $em=$this->getDoctrine()->getManager();

        $ingresoDetalles=$em->getRepository('AlmControlStockBundle:LabAlmDetalleingreso')->findByIngreso($labAlmIngreso);
        if (count($ingresoDetalles)<1) {
            $this->get('ras_flash_alert.alert_reporter')->addError("No se confirmo el ingreso por favor registrar productos ");

            return $this->redirectToRoute('labalmingreso_index');
        }
        $labAlmIngreso->setEstado(2);
        foreach ($ingresoDetalles as $ingresoDetalle) {
            if ($ingresoDetalle->getEstado()==1) {
                $ingresoDetalle->setEstado(2);
                $productolab=$ingresoDetalle->getProductolab();
                $productolab->setStock($productolab->getStock()+$ingresoDetalle->getCantidad());
                $em->persist($productolab);
                $em->persist($ingresoDetalle);
            }
            
        }
        $em->persist($labAlmIngreso);
        $em->flush();
         $this->get('ras_flash_alert.alert_reporter')->addSuccess("Se corfimo  el ingreso");
        return $this->redirectToRoute('labalmingreso_index');
        
    }

    /**
     * Finds and displays a labAlmIngreso entity.
     *
     * @Route("/{id}", name="labalmingreso_show")
     * @Method("GET")
     */
    public function showAction(LabAlmIngreso $labAlmIngreso)
    {
        $em=$this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($labAlmIngreso);
        $ingresoDetalles=$em->getRepository('AlmControlStockBundle:LabAlmDetalleingreso')->findByIngreso($labAlmIngreso);

        return $this->render('labalmingreso/show.html.twig', array(
            'labAlmIngreso' => $labAlmIngreso,
            'labAlmDetalleingresos'=>$ingresoDetalles,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing labAlmIngreso entity.
     *
     * @Route("/{id}/edit", name="labalmingreso_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, LabAlmIngreso $labAlmIngreso)
    {
        $deleteForm = $this->createDeleteForm($labAlmIngreso);
        $editForm = $this->createForm('Alm\ControlStockBundle\Form\LabAlmIngresoType', $labAlmIngreso);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->get('ras_flash_alert.alert_reporter')->addSuccess("SE MODIFICO LOS DATOS GENERALES");

            return $this->redirectToRoute('labalmdetalleingreso_new', array('id' => $labAlmIngreso->getId()));
        }

        return $this->render('labalmingreso/new.html.twig', array(
            'labAlmIngreso' => $labAlmIngreso,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a labAlmIngreso entity.
     *
     * @Route("/{id}", name="labalmingreso_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, LabAlmIngreso $labAlmIngreso)
    {
        $form = $this->createDeleteForm($labAlmIngreso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($labAlmIngreso);
            $em->flush();
            $this->get('ras_flash_alert.alert_reporter')->addSuccess("SE ELIMINO EL INGRESO");
        }

        return $this->redirectToRoute('labalmingreso_index');
    }

    /**
     * Creates a form to delete a labAlmIngreso entity.
     *
     * @param LabAlmIngreso $labAlmIngreso The labAlmIngreso entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LabAlmIngreso $labAlmIngreso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('labalmingreso_delete', array('id' => $labAlmIngreso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
