<?php

namespace HL\FantasiaBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('nombre');
	    $builder->add('apellido');
        $builder->add('dni');
		//$builder->add('presupuestos', 'entity', array( 'class' => 'FantasiaBundle:Presupuesto ));
		
    }

    public function getName()
    {
        return 'hl_user_registration';
    }
}
?>