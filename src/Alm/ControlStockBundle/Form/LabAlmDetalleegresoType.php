<?php

namespace Alm\ControlStockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Alm\ControlStockBundle\Form\DataTransformer\ProductoLabToNumberTransformer;
use Doctrine\ORM\EntityManager;

class LabAlmDetalleegresoType extends AbstractType
{
     private $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('productolab','genemu_jqueryautocomplete_entity',array(
                'class' => 'Alm\ControlStockBundle\Entity\LabAlmProductolab',
                'route_name' => 'buscarProductoLabAjax',
                'invalid_message' => 'No es valido numero de LabAlmProducto',
                'label'=>'Buscar Producto'))->add('cantidad','integer',array('label'=>'Cantidad del Producto'));

        $builder->get('productolab')
            ->addModelTransformer(new ProductoLabToNumberTransformer($this->manager));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Alm\ControlStockBundle\Entity\LabAlmDetalleegreso'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'alm_controlstockbundle_labalmdetalleegreso';
    }


}
