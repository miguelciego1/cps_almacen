<?php

namespace Alm\ControlStockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReporteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
              ->add('fechaInicio','date',array('required'=>true,'label'=>'Desde :'))
              ->add('fechaFin','date',array('required'=>true,'label'=>'Hasta :'))
              ->add('seleccion','choice',array('choices'=>array(true=>'Ingresos',false=>'Egresos')))
              ->add('save', 'submit', array('label' => 'Generar PDF'))
      ;
    }

}
