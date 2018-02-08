<?php
namespace Alm\ControlStockBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class MovimientoAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->with('Datos Generales',array('collapsed'=>true))
                    ->add('numeroEgresoAlmacen',null,array('help'=>'El numero de egreso de almacen es obligatorio solo para los ingresos'))
                    ->add('tipoAux', 'choice', array(
                        'choices' => array(
                            'I' => 'Ingreso',
                            'E'=>'Egreso',
                            'G'=>'Ingreso General'
                        ),'label'=>'Tipo de Movimiento'))
                    ->add('seccionAux', 'choice', array(
                        'choices' => array(
                        'C'=>'Central',
                        'H'=>'Hormonas',
                        'P'=>'Parasitologia',
                        'S'=>'Serologia',
                        'Q'=>'Quimica',
                        'M'=>'Hematologia',
                        'U'=>'Urianalisis',
                        'B'=>'Bacteriologia'),'label'=>'Seccion'))
                    ->add('recibidoPor')
                ->end()
                ->with('Producto',array('description'=>'Agrege controles solo a los reactivos, El control viene en el siguiente orden (producto -- lote -- vencimiento --marca)'))
                    ->add('detalles', 'sonata_type_collection', array('by_reference' => false,
                            'btn_add' => 'Agregar Producto al movimiento',
                            'required' => true,
                            'cascade_validation' => true,
                            'label' => false,
                            'type_options' => array('delete' => true,)),
                             array(
                            'edit' => 'inline',
                            'inline' => 'table',
                            'sortable' => 'position',
                        ))
                ->end();
    }
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete')
            ;
        $collection->add('confirmar', $this->getRouterIdParameter().'/confirmar');

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id',null,array('label'=>'N° Movimiento'))
                        ->add('numeroEgresoAlmacen')
                        ->add('usuario')
                        ->add('creadoEl','doctrine_orm_date')
                        ->add('tipo', 'doctrine_orm_string',array(),
                        'choice' ,array('choices'=>array(
                            'I' =>'Ingreso',
                            'E'=>'Egreso',
                            'G'=>'Ingreso General'
                        ),))
                        ->add('seccion', 'doctrine_orm_string',array(),
                        'choice' ,array('choices'=>array(
                            'C'=>'Central',
                            'H'=>'Hormonas',
                            'P'=>'Parasitologia',
                            'S'=>'Serologia',
                            'Q'=>'Quimica',
                            'M'=>'Hematologia',
                            'U'=>'Urianalisis',
                            'B'=>'Bacteriologia')))
                        ->add('activo');
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {  $showMapper ->add('id',null,array('label'=>'N° Movimiento'))
                    ->add('numeroEgresoAlmacen',null,array('label'=>'Codigo de egreso de almacen general'))
                    ->add('creadoEl',null,array('label'=>'Fecha de registro'))
                    ->add('activo');
    }

    protected function configureListFields(ListMapper $listMapper)
    {

        $listMapper->addIdentifier('id', null, array('label'=>'N° Movimiento'))
                    ->add('numeroEgresoAlmacen',null,array('label'=>'N° Egreso Almacen General'))
                    ->add('creadoEl',null,array('label'=>'Fecha de Registro'))
                    ->add('tipo', 'choice', array('label'=>'Tipo de Movimiento'))
                    ->add('seccion')
                    ->add('activo',null,array('label'=>'Activo ?'))
                    ->add('_action', null, array('label'=>'Accion',
                            'actions' => array(

                                // ...

                                'confirmar' => array(
                                    'template' => 'AlmControlStockBundle:CRUD:list__action_confirmar.html.twig'
                                )
                            )
                        ));
    }
    public function toString($object)
    {
        return $object instanceof Movimiento
            ? $object->getId()
            : 'Movimiento'; // shown in the breadcrumb on the create view
    }

     public function getDataSourceIterator()
    {
        $iterator = parent::getDataSourceIterator();
        $iterator->setDateTimeFormat('d/m/Y'); //change this to suit your needs
        return $iterator;
    }

    public function getExportFormats()
    {
        return array('xls');
    }
}