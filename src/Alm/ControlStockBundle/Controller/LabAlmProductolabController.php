<?php

namespace Alm\ControlStockBundle\Controller;

use Alm\ControlStockBundle\Entity\LabAlmProductolab;
use Alm\ControlStockBundle\Form\LabAlmProductolabType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Labalmproductolab controller.
 *
 * @Route("labalmproductolab")
 */
class LabAlmProductolabController extends Controller
{
    /**
     * Lists all labAlmProductolab entities.
     *
     * @Route("/", name="labalmproductolab_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
        throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();
        $session = $this->getRequest()->getSession();
        $session->set('empleadoLog',$user);

        $em = $this->getDoctrine()->getManager();

        $labAlmProductolabs = $em->getRepository('AlmControlStockBundle:LabAlmProductolab')->findAll();

        return $this->render('labalmproductolab/index.html.twig', array(
            'labAlmProductolabs' => $labAlmProductolabs,
        ));
    }

    /**
     * Creates a new labAlmProductolab entity.
     *
     * @Route("/new", name="labalmproductolab_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $labAlmProductolab = new Labalmproductolab();
        $form = $this->createForm(new LabAlmProductolabType($em), $labAlmProductolab);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $labAlmProductolab->setEstado(0);
            $labAlmProductolab->setStock(0);
            $em->persist($labAlmProductolab);
            $em->flush($labAlmProductolab);
            $this->get('ras_flash_alert.alert_reporter')->addSuccess("PRODUCTO REGISTRADO CON EXITO");
            return $this->redirectToRoute('labalmproductolab_show', array('id' => $labAlmProductolab->getId()));
        }

        return $this->render('labalmproductolab/new.html.twig', array(
            'labAlmProductolab' => $labAlmProductolab,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a labAlmProductolab entity.
     *
     * @Route("/{id}", name="labalmproductolab_show")
     * @Method("GET")
     */
    public function showAction(LabAlmProductolab $labAlmProductolab)
    {
        $deleteForm = $this->createDeleteForm($labAlmProductolab);

        return $this->render('labalmproductolab/show.html.twig', array(
            'labAlmProductolab' => $labAlmProductolab,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing labAlmProductolab entity.
     *
     * @Route("/{id}/edit", name="labalmproductolab_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, LabAlmProductolab $labAlmProductolab)
    {
        $em=$this->getDoctrine()->getManager();
        $editForm = $this->createForm(new LabAlmProductolabType($em), $labAlmProductolab);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->flush();
            $this->get('ras_flash_alert.alert_reporter')->addSuccess("PRODUCTO EDITADO");
            return $this->redirectToRoute('labalmproductolab_edit', array('id' => $labAlmProductolab->getId()));
        }

        return $this->render('labalmproductolab/edit.html.twig', array(
            'labAlmProductolab' => $labAlmProductolab,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a labAlmProductolab entity.
     *
     * @Route("/{id}/delete/", name="labalmproductolab_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, LabAlmProductolab $labAlmProductolab)
    {
            $em = $this->getDoctrine()->getManager();

            if (is_null($productos=$em->getRepository('AlmControlStockBundle:LabAlmDetalleingreso')->findOneByProductolab($labAlmProductolab))) {
                $em->remove($labAlmProductolab);
                $em->flush();
                $this->get('ras_flash_alert.alert_reporter')->addSuccess("PRODUCTO ELIMINADO");
            }
            else
            {
                $this->get('ras_flash_alert.alert_reporter')->addError("NO SE PUEDE ELIMINAR EL PRODUCTO ");
            }
            

        return $this->redirectToRoute('labalmproductolab_index');
    }

    /**
     * Creates a form to delete a labAlmProductolab entity.
     *
     * @param LabAlmProductolab $labAlmProductolab The labAlmProductolab entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LabAlmProductolab $labAlmProductolab)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('labalmproductolab_delete', array('id' => $labAlmProductolab->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @Route("/buscarProductoAjax/" , name="buscarProductoAjax")
     */
    public function buscarProductoAjaxAction(Request $request)
    {
      $value = $request->get('term');
      $value=strtoupper($value);

      $em = $this->getDoctrine()->getManager();

      $productos = $em->getRepository('AlmControlStockBundle:AlmAdmProducto')->findAjaxValue($value);


      $json = array();
      foreach ($productos as $producto) {
          $json[] = array(
              'label' => $producto->getNombre(),
              'value' => $producto->getCodPro()
          );
      }
      $response = new Response(json_encode($json));
      $response->headers->set('Content-Type', 'application/json');
      return $response;
    }
    /**
     * @Route("/buscarProductoLabAjax/" , name="buscarProductoLabAjax")
     */
    public function buscarProductoLabAjaxAction(Request $request)
    {
      $value = $request->get('term');
      $value=strtoupper($value);

      $em = $this->getDoctrine()->getManager();

      $productos = $em->getRepository('AlmControlStockBundle:LabAlmProductolab')->findAjaxValue($value,2);


      $json = array();
      foreach ($productos as $producto) {
          $json[] = array(
              'label' => $producto->getProducto()->getNombre(),
              'value' => $producto->getProducto()->getCodPro()
          );
      }
      $response = new Response(json_encode($json));
      $response->headers->set('Content-Type', 'application/json');
      return $response;
    }
}
