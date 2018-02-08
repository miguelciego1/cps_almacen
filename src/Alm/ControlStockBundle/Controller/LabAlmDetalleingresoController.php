<?php

namespace Alm\ControlStockBundle\Controller;

use Alm\ControlStockBundle\Entity\LabAlmDetalleingreso;
use Alm\ControlStockBundle\Entity\LabAlmIngreso;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Alm\ControlStockBundle\Form\LabAlmDetalleingresoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Labalmdetalleingreso controller.
 *
 * @Route("labalmdetalleingreso")
 */
class LabAlmDetalleingresoController extends Controller
{
    /**
     * Lists all labAlmDetalleingreso entities.
     *
     * @Route("/{id}/index", name="labalmdetalleingreso_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(LabAlmIngreso $labAlmIngreso )
    {
        $em = $this->getDoctrine()->getManager();

        $labAlmDetalleingresos = $em->getRepository('AlmControlStockBundle:LabAlmDetalleingreso')->findByIngreso($labAlmIngreso);

        return $this->render('labalmdetalleingreso/index.html.twig', array(
            'labAlmDetalleingresos' => $labAlmDetalleingresos,
        ));
    }

    /**
     * Creates a new labAlmDetalleingreso entity.
     *
     * @Route("/{id}/new", name="labalmdetalleingreso_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(LabAlmIngreso $labAlmIngreso ,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $labAlmDetalleingreso = new Labalmdetalleingreso();
        $labAlmDetalleingreso->setIngreso($labAlmIngreso);
        $form = $this->createForm(new LabAlmDetalleingresoType($em), $labAlmDetalleingreso);
        $ingresoDetalles=$em->getRepository('AlmControlStockBundle:LabAlmDetalleingreso')->findByIngreso($labAlmIngreso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
    
            $labAlmDetalleingreso->setEstado(1);
            $em->persist($labAlmDetalleingreso);
            $em->flush($labAlmDetalleingreso);
            $this->get('ras_flash_alert.alert_reporter')->addSuccess("Se guardo el producto ".$labAlmDetalleingreso->getProductolab()->getProducto()->getNombre());

            return $this->redirectToRoute('labalmdetalleingreso_new', array('id' => $labAlmIngreso->getId()));
        }

        return $this->render('labalmdetalleingreso/new.html.twig', array(
            'labAlmIngreso'=>$labAlmDetalleingreso->getIngreso(),
            'labAlmDetalleingreso' => $labAlmDetalleingreso,
            'labAlmDetalles'=>$ingresoDetalles,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a labAlmDetalleingreso entity.
     *
     * @Route("/{id}", name="labalmdetalleingreso_show")
     * @Method("GET")
     */
    public function showAction(LabAlmDetalleingreso $labAlmDetalleingreso)
    {
        $deleteForm = $this->createDeleteForm($labAlmDetalleingreso);

        return $this->render('labalmdetalleingreso/show.html.twig', array(
            'labAlmDetalleingreso' => $labAlmDetalleingreso,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing labAlmDetalleingreso entity.
     *
     * @Route("/{id}/edit", name="labalmdetalleingreso_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, LabAlmDetalleingreso $labAlmDetalleingreso)
    {
        $em=$this->getDoctrine()->getManager();
        $editForm = $this->createForm(new LabAlmDetalleingresoType($em), $labAlmDetalleingreso);
        $ingresoDetalles=$em->getRepository('AlmControlStockBundle:LabAlmDetalleingreso')->findByIngreso($labAlmDetalleingreso->getIngreso());
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->flush();

            $this->get('ras_flash_alert.alert_reporter')->addSuccess("SE MODIFICO CORRECTAMENTE EL PRODUCTO");
            return $this->redirectToRoute('labalmdetalleingreso_new', array('id' => $labAlmDetalleingreso->getIngreso()->getId()));
        }

        return $this->render('labalmdetalleingreso/new.html.twig', array(
            'labAlmIngreso'=>$labAlmDetalleingreso->getIngreso(),
            'labAlmDetalleingreso' => $labAlmDetalleingreso,
            'labAlmDetalles'=>$ingresoDetalles,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a labAlmDetalleingreso entity.
     *
     * @Route("/{id}", name="labalmdetalleingreso_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, LabAlmDetalleingreso $labAlmDetalleingreso)
    {
        $form = $this->createDeleteForm($labAlmDetalleingreso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($labAlmDetalleingreso);
            $em->flush();
        }

        return $this->redirectToRoute('labalmdetalleingreso_index');
    }

    /**
     * Creates a form to delete a labAlmDetalleingreso entity.
     *
     * @param LabAlmDetalleingreso $labAlmDetalleingreso The labAlmDetalleingreso entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LabAlmDetalleingreso $labAlmDetalleingreso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('labalmdetalleingreso_delete', array('id' => $labAlmDetalleingreso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
