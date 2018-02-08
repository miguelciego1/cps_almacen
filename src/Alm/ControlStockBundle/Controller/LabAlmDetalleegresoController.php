<?php

namespace Alm\ControlStockBundle\Controller;

use Alm\ControlStockBundle\Entity\LabAlmDetalleegreso;
use Alm\ControlStockBundle\Entity\LabAlmEgreso;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Alm\ControlStockBundle\Form\LabAlmDetalleegresoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Labalmdetalleegreso controller.
 *
 * @Route("labalmdetalleegreso")
 */
class LabAlmDetalleegresoController extends Controller
{
    /**
     * Lists all labAlmDetalleegreso entities.
     *
     * @Route("/", name="labalmdetalleegreso_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $labAlmDetalleegresos = $em->getRepository('AlmControlStockBundle:LabAlmDetalleegreso')->findAll();

        return $this->render('labalmdetalleegreso/index.html.twig', array(
            'labAlmDetalleegresos' => $labAlmDetalleegresos,
        ));
    }

    /**
     * Creates a new labAlmDetalleegreso entity.
     *
     * @Route("/{id}/new", name="labalmdetalleegreso_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(LabAlmEgreso $labAlmEgreso,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $labAlmDetalleegreso = new Labalmdetalleegreso();
        $labAlmDetalleegreso->setEgreso($labAlmEgreso);
        $form = $this->createForm(new LabAlmDetalleegresoType($em), $labAlmDetalleegreso);
        $egresoDetalles=$em->getRepository('AlmControlStockBundle:LabAlmDetalleegreso')->findByEgreso($labAlmEgreso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $labAlmDetalleegreso->setEstado(1);
            $em->persist($labAlmDetalleegreso);
            $em->flush($labAlmDetalleegreso);

            $this->get('ras_flash_alert.alert_reporter')->addSuccess("SE GUARDO EL PRODUCTO ".$labAlmDetalleegreso->getProductolab()->getProducto()->getNombre());

            return $this->redirectToRoute('labalmdetalleegreso_new', array('id' => $labAlmEgreso->getId()));
        }

        return $this->render('labalmdetalleegreso/new.html.twig', array(
            'labAlmEgreso'=>$labAlmEgreso,
            'labAlmDetalleegreso' => $labAlmDetalleegreso,
            'labAlmDetalles'=>$egresoDetalles,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a labAlmDetalleegreso entity.
     *
     * @Route("/{id}", name="labalmdetalleegreso_show")
     * @Method("GET")
     */
    public function showAction(LabAlmDetalleegreso $labAlmDetalleegreso)
    {
        $deleteForm = $this->createDeleteForm($labAlmDetalleegreso);

        return $this->render('labalmdetalleegreso/show.html.twig', array(
            'labAlmDetalleegreso' => $labAlmDetalleegreso,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing labAlmDetalleegreso entity.
     *
     * @Route("/{id}/edit", name="labalmdetalleegreso_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, LabAlmDetalleegreso $labAlmDetalleegreso)
    {
        $em=$this->getDoctrine()->getManager();
        $editForm = $this->createForm(new LabAlmDetalleegresoType($em), $labAlmDetalleegreso);
        $egresoDetalles=$em->getRepository('AlmControlStockBundle:LabAlmDetalleegreso')->findByEgreso($labAlmDetalleegreso->getEgreso());
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->flush();
            $this->get('ras_flash_alert.alert_reporter')->addSuccess("SE MODIFICO CORRECTAMENTE EL PRODUCTO");
            return $this->redirectToRoute('labalmdetalleegreso_new', array('id' => $labAlmDetalleegreso->getEgreso()->getId()));
        }

        return $this->render('labalmdetalleegreso/new.html.twig', array(
            'labAlmEgreso'=>$labAlmDetalleegreso->getEgreso(),
            'labAlmDetalleegreso' => $labAlmDetalleegreso,
            'labAlmDetalles'=>$egresoDetalles,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a labAlmDetalleegreso entity.
     *
     * @Route("/{id}", name="labalmdetalleegreso_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, LabAlmDetalleegreso $labAlmDetalleegreso)
    {
        $form = $this->createDeleteForm($labAlmDetalleegreso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($labAlmDetalleegreso);
            $em->flush();
        }

        return $this->redirectToRoute('labalmdetalleegreso_index');
    }

    /**
     * Creates a form to delete a labAlmDetalleegreso entity.
     *
     * @param LabAlmDetalleegreso $labAlmDetalleegreso The labAlmDetalleegreso entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LabAlmDetalleegreso $labAlmDetalleegreso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('labalmdetalleegreso_delete', array('id' => $labAlmDetalleegreso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
