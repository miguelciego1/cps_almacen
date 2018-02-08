<?php

namespace Alm\ControlStockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LabAlmEgresoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $secciones=array('SEROLOGIA'=>'SEROLOGIA','QUIMICA'=>'QUIMICA','HEMATOLOGIA'=>'HEMATOLOGIA','HORMONAS'=>'HORMONAS','BACTERIOLOGIA'=>'BACTERIOLOGIA','PARASITOLOGIA'=>'PARASITOLOGIA','URIANALISIS'=>'URIANALISIS');
        $builder->add('recibidoPor')->add('seccion','choice',array('choices'=>$secciones));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Alm\ControlStockBundle\Entity\LabAlmEgreso'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'alm_controlstockbundle_labalmegreso';
    }


}
