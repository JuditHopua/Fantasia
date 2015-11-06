<?php

namespace HL\FantasiaBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('nombre');
	    $builder->add('apellido');
        $builder->add('dni');
    }

    public function getName()
    {
        return 'hl_user_registration';
    }
}
?>