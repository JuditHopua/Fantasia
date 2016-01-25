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
		$fechaActual=new \DateTime();
        $fechaActual->format('Y-m-d');
        $builder
            ->add('fecha','date', ['widget' => 'single_text', 
									'format' => 'dd-MM-yyyy','attr' => ['class' => 'form-control input-inline datepicker',
																		'data-provide' => 'datepicker',
																		
																		'data-date-format' => 'dd-mm-yyyy' ] ] )
																										
            ->add('cliente','entity',array(   'label'=>'Cliente: ',
                                                'class'=>'FantasiaBundle:Cliente',
												'query_builder' => function(\HL\FantasiaBundle\Entity\ClienteRepository $clientes) {
																	 return $clientes->createQueryBuilder('c')
																	->orderBy('c.apellido', 'ASC');
																	},
                                                'property'=>'apellido'+'nombre',
												'placeholder'=>'Seleccione un cliente...',
												
                                                'attr'=>array( 'required'=>'true','class'=>"chzn-select") ));	
			
		
        
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
