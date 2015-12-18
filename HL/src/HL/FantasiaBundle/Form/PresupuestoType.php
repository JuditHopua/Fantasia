<?php

namespace HL\FantasiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PresupuestoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha')
            ->add('costoEnvio')
            ->add('costoColocacion')
            ->add('plazoEntrega')
            ->add('montoTotalCarpinterias')
            ->add('cliente','entity',array(   'label'=>'Cliente: ',
                                                'class'=>'FantasiaBundle:Cliente',
                                                'property'=>'apellido',
                                                'attr'=>array( 'required'=>'true','class'=>"chzn-select") ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HL\FantasiaBundle\Entity\Presupuesto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hl_fantasiabundle_presupuesto';
    }
}
