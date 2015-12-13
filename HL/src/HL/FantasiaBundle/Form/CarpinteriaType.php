<?php

namespace HL\FantasiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CarpinteriaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('alto')
            ->add('ancho')
            ->add('premarco')
            ->add('contramarco')
            ->add('cantidad')
            ->add('vidrio','entity',array(   'label'=>'Vidrio: ',
                                                'class'=>'FantasiaBundle:Vidrio',
                                                'property'=>'tipo',
                                                'attr'=>array( 'required'=>'true','class'=>"chzn-select") ))
			->add('asignacion','entity',array(  'label'=>'Abertura: ',
                                               'class'=>'FantasiaBundle:AsignacionMarcaModelo',
                                            'property'=>'id',
											'attr'=>array( 'required'=>'true','class'=>"chzn-select") ))
									  			
		    //->add('presupuesto')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HL\FantasiaBundle\Entity\Carpinteria'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hl_fantasiabundle_carpinteria';
    }
}
