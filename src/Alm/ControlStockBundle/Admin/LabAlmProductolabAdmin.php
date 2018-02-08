<?php 
namespace Alm\ControlStockBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class LabAlmProductolabAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('producto', 'sonata_type_model_autocomplete', array('help'=>'Buscar por Nombre de producto','property' => 'nombre','to_string_callback' => function($entity, $property) {
                        return $entity->getNombre();
                        }
                        ))
                    ->add('presentacion')
                    ->add('tipo','choice',array('choices'=>array('R'=>'Reactivo','I'=>'Insumo')))
                    ->add('minimo',null,array('help'=>'La cantidad maxima de producto que debe existir en el almacem de laboratorio'))
                    ->add('activo',null,array('label'=>'Activo ?'));
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('delete')
            ;

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                        ->add('id')
                        ->add('producto.codpro',null,array('label'=>'Codigo producto almacen'))
                        ->add('producto.nombre',null,array('label'=>'Descripcion'))
                        ->add('tipo', 'doctrine_orm_string',array(),
                        'choice' ,array('choices'=>array(
                            'R' => 'Reactivos',
                            'I' => 'Insumos'
                        ),))
                        ->add('estado', 'doctrine_orm_string',array(),
                        'choice' ,array('choices'=>array(
                            '0' => 'Agotado',
                            '1' => 'Por agotarse',
                            '2'=>'Disponible'
                        ),))
                        ->add('stock',null,array('label'=>'Saldo'))
                        ->add('stockGeneral',null,array('label'=>'Saldo General'))
                        ->add('activo');
    }


    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('producto.codpro', null, array(
                                    'label'=>'Codigo de producto almacen'))
                    ->add('producto.nombre',null,array('label'=>'Descripcion'))
                    ->add('presentacion')
                    ->add('tipo')
                    // , 'choice', array(
                    //     'choices' => array(
                    //         'R' => 'Reactivo',
                    //         'I' => 'Insumo',
                    //     ),)
                    ->add('estado', 'choice', array(
                        'choices' => array(
                            '0' => 'Agotado',
                            '1' => 'Por agortarse',
                            '2' => 'Disponible'
                        ),))
                    ->add('stock',null,array('label'=>'Saldo'))
                    ->add('stockGeneral',null,array('label'=>'Saldo General'))
                    ->add('minimo',null,array('label'=>'Minimo'))
                    ->add('activo',null,array('editable'=>true));
    }
    public function toString($object)
    {
        return $object instanceof AlmacenProductoLaboratorio
            ? $object->getProducto()->getNombre()
            : 'Producto de Laboratorio'; // shown in the breadcrumb on the create view
    }

    public function getExportFields()
    {
        return array($this->trans('Codigo de Producto')=>'producto.codpro', $this->trans('Nombre de producto')=>'producto.nombre',$this->trans('Presentacion')=>'presentacion',$this->trans('Tipo')=>'tipo',$this->trans('Minimo')=>'minimo',$this->trans('Saldo')=>'stock',$this->trans('Saldo General')=>'stockGeneral');
    }

    public function getExportFormats()
    {
        return array('xls');
    }

    public function configureExportFields(AdminInterface $admin, array $fields)
    {
        $fields['minimo']=700;

        return $fields;
    }
    
}