<?php 
namespace Alm\ControlStockBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class LabAlmDetallecontroliAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('control','sonata_type_model',array('attr'=>array('class'=>'select2','data-sonata-select2' => 'true'),'sortable' => true,'property'=>'string','btn_add'=>'Crear Control'))
                    ->add('cantidad')
                   ;

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('detalleMovimiento.productolab.producto.codpro',null,array('label'=>'Codigo de Producto'))
                    ->add('detalleMovimiento.movimiento.id',null,array('label'=>'N° de Movimiento'))
                    ->add('detalleMovimiento.movimiento.creadoEl',null,array('label'=>'Fecha de Recibido'))
                    ->add('control.marca',null,array('label'=>'Marca'))
                    ->add('control.vencimiento',null,array('label'=>'Vencimineto'))
                    ->add('control.lote',null,array('label'=>'Lote'))
                    ->add('control.productolab.presentacion',null,array('label'=>'Presentacion'))
                    ->add('detalleMovimiento.cantidad',null,array('label'=>'Cantidad'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {

        $listMapper->add('detalleMovimiento.productolab.producto.codpro',null,array('label'=>'Codigo de Producto'))
                    ->add('detalleMovimiento.movimiento.id',null,array('label'=>'N° de Movimiento'))
                    ->add('detalleMovimiento.movimiento.creadoEl',null,array('label'=>'Fecha de Registro'))
                    ->add('detalleMovimiento.movimiento.tipo', 'choice', array('label'=>'Tipo de Movimiento'))
                    ->add('control.marca',null,array('label'=>'Marca'))
                    ->add('control.vencimiento',null,array('label'=>'Vencimineto'))
                    ->add('control.lote',null,array('label'=>'Lote'))
                    ->add('control.productolab.presentacion',null,array('label'=>'Presentacion'))
                    ->add('cantidad',null,array('label'=>'Cantidad'))
                    ->add('saldo',null,array('label'=>'Saldo'));
                    // ->add('fechaRecibido')
                    // ->add('estado', 'choice', array(
                    //     'editable' => true,
                    //     'choices' => array(
                    //         '0' => 'Anulado',
                    //         '1' => 'En Proceso',
                    //         '2'=>'Confirmado',
                    //     ),));
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete')
            ;

    }

     public function getDataSourceIterator()
    {
        $iterator = parent::getDataSourceIterator();
        $iterator->setDateTimeFormat('d/m/Y'); //change this to suit your needs
        return $iterator;
    }

    public function getExportFields()
    {
        return array(
            $this->trans('Codigo de Producto')=>'detalleMovimiento.productolab.producto.codpro', 
            $this->trans('N° de Movimiento')=>'detalleMovimiento.movimiento.id',
            $this->trans('Fecha de registro')=>'detalleMovimiento.movimiento.creadoEl',
            $this->trans('Tipo')=>'detalleMovimiento.movimiento.tipo',
            $this->trans('Marca')=>'control.marca',
            $this->trans('Vencimiento')=>'control.vencimiento',
            $this->trans('Lote')=>'control.lote',
            $this->trans('Presentacion')=>'control.productolab.presentacion',
            $this->trans('Cantidad')=>'cantidad',
            $this->trans('Saldo')=>'saldo');
    }


    public function getExportFormats()
    {
        return array('xls');
    }
    // public function toString($object)
    // {
    //     return $object instanceof LabAlmIngreso
    //         ? $object->getId()
    //         : 'Ingreso'; // shown in the breadcrumb on the create view
    // }
}