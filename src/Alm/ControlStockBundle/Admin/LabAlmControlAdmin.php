<?php 
namespace Alm\ControlStockBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class LabAlmControlAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {


        $em = $this->modelManager->getEntityManager('Alm\ControlStockBundle\Entity\AlmacenProductoLaboratorio');
        $query = $em->createQuery('SELECT e FROM AlmControlStockBundle:AlmacenProductoLaboratorio e WHERE e.tipo =:tipo')->setParameter('tipo','R');

        $formMapper
                ->with('Datos Generales')
                        ->add('productolab', 'sonata_type_model', array(
                                'property' => 'producto.nombre',
                                'query'=>$query))
                    
                    ->add('lote')
                    ->add('vencimiento','sonata_type_date_picker')
                    ->add('marca')
                ->end();
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('delete')
            ;

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id')
                        ->add('productolab.producto.codpro')
                        ->add('lote')
                        ->add('vencimiento','doctrine_orm_date')
                        ->add('marca')
                        ->add('activo');
    }

    protected function configureListFields(ListMapper $listMapper)
    {

        $listMapper->addIdentifier('id', null, array(
                                    'route' => array('name' => 'show'),'label'=>'N°'))
                        ->add('productolab.producto.codpro',null,array('label'=>'Codigo de Producto Almacen'))
                        ->add('productolab.producto.nombre',null,array('label'=>'Descripcion'))
                        ->add('lote',null,array('label'=>'Lote'))
                        ->add('vencimiento',null,array('label'=>'vencimiento'))
                        ->add('marca',null,array('label'=>'Marca'))
                        ->add('activo',null,array('label'=>'Activo ?'));
    }

    public function toString($object)
    {
        return $object instanceof ControlReactivo
            ? $object->getId()
            : 'Control Reactivo'; // shown in the breadcrumb on the create view
    }
    
}