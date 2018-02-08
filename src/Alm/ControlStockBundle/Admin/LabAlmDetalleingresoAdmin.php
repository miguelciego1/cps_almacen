<?php 
namespace Alm\ControlStockBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class LabAlmDetalleingresoAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                    ->add('productolab','sonata_type_model',array('attr'=>array('class'=>'select2','data-sonata-select2' => 'true'),'sortable' => true,'property'=>'producto.nombre','btn_add'=>'Crear Producto','label'=>'Producto'))
        			// ->add('productolab','sonata_type_model_autocomplete',array('property'=>'producto.nombre',
           //              'to_string_callback' => function($entity, $property) {
           //              return $entity->getProducto()->getNombre();
                       
           //              },))
                    ->add('cantidad')
                    ->add('detalles','sonata_type_collection', array('by_reference' => false, 
                            'btn_add' => 'Agregar Control al Producto',
                            'required' => true,
                            'cascade_validation' => true,
                            'label' => 'Detalles',
                            'type_options' => array('delete' => true,)),
                             array(
                            'edit' => 'inline',
                            'inline' => 'table',
                            'sortable' => 'position',
                        ))
    
                   ;

    }

     protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper 
                    ->add('productolab',null,array('label'=>'Producto'))
                    ->add('cantidad',null,array('label'=>'Cantidad'))
                    ;
    }

    // protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    // {
    //     $datagridMapper->add('id')
    //                     ->add('fechaRecibido')
    //                     ->add('numeroEgresoAlmacen')
    //                     ->add('usuario')
    //                     ->add('creadoEl');
    // }

    // protected function configureListFields(ListMapper $listMapper)
    // {

    //     $listMapper->addIdentifier('id')
    //                 ->add('numeroEgresoAlmacen')
    //                 ->add('fechaRecibido')
    //                 ->add('estado', 'choice', array(
    //                     'editable' => true,
    //                     'choices' => array(
    //                         '0' => 'Anulado',
    //                         '1' => 'En Proceso',
    //                         '2'=>'Confirmado',
    //                     ),));
    // }
    // public function toString($object)
    // {
    //     return $object instanceof LabAlmIngreso
    //         ? $object->getId()
    //         : 'Ingreso'; // shown in the breadcrumb on the create view
    // }
}