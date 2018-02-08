<?php

namespace Alm\ControlStockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Alm\ControlStockBundle\Form\DataTransformer\ProductoToNumberTransformer;
use Doctrine\ORM\EntityManager;

class LabAlmProductolabType extends AbstractType
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
        $builder->add('producto','genemu_jqueryautocomplete_entity',array(
                'class' => 'Alm\ControlStockBundle\Entity\AlmAdmProducto',
                'route_name' => 'buscarProductoAjax',
                'invalid_message' => 'No es valido numero de AlmAdmProducto'))
                ->add('presentacion')
                ->add('tipo','choice',array('choices'=>array('R'=>'Reactivo','I'=>'Insumo')))
                ->add('minimo');
        $builder->get('producto')
            ->addModelTransformer(new ProductoToNumberTransformer($this->manager));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Alm\ControlStockBundle\Entity\LabAlmProductolab'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'alm_controlstockbundle_labalmproductolab';
    }


}
