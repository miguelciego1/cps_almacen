<?php

namespace Alm\ControlStockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Alm\ControlStockBundle\Form\DataTransformer\EmpleadoToNumberTransformer;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class LabAlmUsuarioType extends AbstractType
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
        $secciones=array('SEROLOGIA'=>'SEROLOGIA','QUIMICA'=>'QUIMICA','HEMATOLOGIA'=>'HEMATOLOGIA','HORMONAS'=>'HORMONAS','BACTERIOLOGIA'=>'BACTERIOLOGIA','PARASITOLOGIA'=>'PARASITOLOGIA','URIANALISIS'=>'URIANALISIS','CENTRAL'=>'CENTRAL');
        $builder
        ->add('empleado', 'genemu_jqueryautocomplete_entity', array(
        'class' => 'Cps\Personal\ArchivoBundle\Entity\Empleado',
        'route_name' => 'buscarEmpleadoAjax'
        ))
        ->add('password','repeated', array(
                'type' => 'password',
                'invalid_message' => 'El password no coincide',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => true,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repita Password'),
            ))
        ->add('seccion','choice',array('choices'=>$secciones))
        ;
        $builder->get('empleado')
            ->addModelTransformer(new EmpleadoToNumberTransformer($this->manager));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Alm\ControlStockBundle\Entity\LabAlmUsuario'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'alm_controlstockbundle_labalmusuario';
    }


}
