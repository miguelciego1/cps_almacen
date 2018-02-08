<?php

namespace Alm\ControlStockBundle\Controller;

use Alm\ControlStockBundle\Entity\LabAlmUsuario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Alm\ControlStockBundle\Form\LabAlmUsuarioType;

/**
 * Labalmusuario controller.
 *
 * @Route("labalmusuario")
 */
class LabAlmUsuarioController extends Controller
{
    /**
     * Lists all labAlmUsuario entities.
     *
     * @Route("/", name="labalmusuario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $labAlmUsuarios = $em->getRepository('AlmControlStockBundle:LabAlmUsuario')->findAll();

        return $this->render('labalmusuario/index.html.twig', array(
            'labAlmUsuarios' => $labAlmUsuarios,
        ));
    }

    /**
     * Creates a new labAlmUsuario entity.
     *
     * @Route("/new", name="labalmusuario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $labAlmUsuario = new Labalmusuario();
        $form = $this->createForm(new LabAlmUsuarioType($em), $labAlmUsuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $encoder = $this->container->get('security.password_encoder');
            $labAlmUsuario->setEstado(1);
            $labAlmUsuario->setLogin($labAlmUsuario->getEmpleado()->getId());
            $encoded = $encoder->encodePassword($labAlmUsuario, $labAlmUsuario->getPassword());
            $labAlmUsuario->setPassword($encoded);
            $labAlmUsuario->setModificadoEl(new \DateTime("now"));
            $labAlmUsuario->setCreadoEl(new \DateTime("now"));
            $em->persist($labAlmUsuario);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('labalmusuario/new.html.twig', array(
            'labAlmUsuario' => $labAlmUsuario,
            'form' => $form->createView(),
        ));
    }

}
