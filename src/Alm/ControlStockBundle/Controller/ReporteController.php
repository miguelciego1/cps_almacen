<?php

namespace Alm\ControlStockBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Response;

/**
 * reporte controller.
 *
 * @Route("/reporte")
 */
class ReporteController extends Controller
{
    /**
     * Formulario de reporte para generar reporte.
     *
     * @Route("/", name="reporte_index1")
     * @Method({"GET", "POST"})
     */
    public function index1Action()
    {
        return $this->render('reporte/index.html.twig');
    }

    /**
     * Formulario de reporte para generar reporte.
     *
     * @Route("/index/", name="reporte_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        // ==================================crea el formulario del reporte vacacion======================================================
        // ======================================================================================================================
        $reporte=array('fechaInicio'=>null,'fechaFin'=>null,'seleccion'=>null);
        $reporteP=array('estado'=>null);
        $form = $this->createForm('Alm\ControlStockBundle\Form\ReporteType',$reporte);
        $formP = $this->createForm('Alm\ControlStockBundle\Form\ReportePType',$reporteP);
        $form->handleRequest($request);
        $formP->handleRequest($request);

          if ($form->isSubmitted() && $form->get('save')->isClicked()) {
                    $em=$this->getDoctrine()->getManager();
                    $data=$form->getData();
                    if ($data['seleccion']) {
                        $fecIni=$data['fechaInicio'];
                        $fecFin=$data['fechaFin'];

                        if(!is_null($fecIni) ){
                            $fecIni=$fecIni->format('Y-m-d');
                            if(!is_null($fecFin)){
                            $fecFin=$fecFin->format('Y-m-d');
                            }
                        }

                        $LabAlmDetalleingresos=$em->getRepository('AlmControlStockBundle:LabAlmDetalleingreso')->findByFechas($fecIni,$fecFin);

                          //pdf----------------------------------------------
                          $html = $this->renderView('reporte/reporteIngresos.html.twig', array(
                              'detalleIngresos'=>$LabAlmDetalleingresos,
                          ));

                          $filename = sprintf('ReporteIngresos-%s.pdf', date('Y-m-d'));
                    }else{

                      $fecIni=$data['fechaInicio'];
                      $fecFin=$data['fechaFin'];
                      //$empleadoId=$data['empleadoId'];

                      $fecIni=$fecIni->format('Y-m-d');
                      $fecFin=$fecFin->format('Y-m-d');

                      $LabAlmDetalleegresos=$em->getRepository('AlmControlStockBundle:LabAlmDetalleegreso')->findByFechas($fecIni,$fecFin);

                      $html = $this->renderView('reporte/reporteEgresos.html.twig', array(
                        'fIni'=>$fecIni,'fFin'=>$fecFin,
                              'detalleEgresos'=>$LabAlmDetalleegresos
                          ));

                      $filename = sprintf('ReporteEgresos-%s.pdf', date('Y-m-d'));

                    }
              

                    $response= new Response(
                            $this->get('knp_snappy.pdf')->getOutputFromHtml($html,
                            array('lowquality' => false,
                                    'encoding' => 'utf-8',
                                    'page-size' => 'Letter',
                                    'outline-depth' => 8,
                                    'orientation' => 'Landscape',
                                    'title'=> 'Reporte Vacacion',
                                    'header-font-size'=>7
                                    )),
                            200,
                            array(
                                'Content-Type'        => 'application/pdf',
                                'Content-Disposition' => sprintf('attachment ; filename="%s"', $filename),
                            )
                        );
                        return $response;}


          if ($formP->isSubmitted() && $formP->get('saveP')->isClicked()) {
                     $em=$this->getDoctrine()->getManager();
                    $data=$formP->getData();
                    
                    $productos=$em->getRepository('AlmControlStockBundle:LabAlmProductolab')->findByEstadoPersonalizado($data['estado']);

                    $html = $this->renderView('reporte/reporteProducto.html.twig', array(
                              'productos'=>$productos
                          ));

                      $filenamep = sprintf('ReporteProductos-%s.pdf', date('Y-m-d'));
                      $responsep= new Response(
                            $this->get('knp_snappy.pdf')->getOutputFromHtml($html,
                            array('lowquality' => false,
                                    'encoding' => 'utf-8',
                                    'page-size' => 'Letter',
                                    'outline-depth' => 8,
                                    'orientation' => 'Portrait',
                                    'title'=> 'Reporte productos',
                                    'header-font-size'=>7
                                    )),
                            200,
                            array(
                                'Content-Type'        => 'application/pdf',
                                'Content-Disposition' => sprintf('online ; filename="%s"', $filenamep),
                            )
                        );
                      return $responsep;
              
                  }



        return $this->render('reporte/index.html.twig',array('form'=>$form->createView(),
                                                              'formP'=>$formP->createView()));
    }


}
