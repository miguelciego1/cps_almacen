<?php 
namespace Alm\ControlStockBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class AlmAdmProductoAdmin extends AbstractAdmin
{
   

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('codpro')
        				->add('nombre')
                        ;
    }
    protected function configureListFields(ListMapper $listMapper)
    {
    	$listMapper->add('codpro')
    	->add('productolab.estado');
    }

   

}