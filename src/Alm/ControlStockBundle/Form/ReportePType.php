<?php

namespace Alm\ControlStockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReportePType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
              ->add('estado','choice',array('choices'=>array('1'=>'POR AGOTARSE','2'=>'DISPONIBLE','0'=>'AGOTADOS','3'=>'TODOS')))
              ->add('saveP', 'submit', array('label' => 'Generar PDF'))
      ;
    }

}
