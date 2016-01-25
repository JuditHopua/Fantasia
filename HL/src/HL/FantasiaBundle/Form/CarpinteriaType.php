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
			->add('vidrio','entity',array(   'label'=>'Vidrio',
                                             'class'=>'FantasiaBundle:Vidrio',
											 'query_builder' => function(\HL\FantasiaBundle\Entity\VidrioRepository $vidrios) {
																 return $vidrios->createQueryBuilder('v')
																->orderBy('v.tipo', 'ASC');
																},
                                             'property'=>'tipo',
											 'placeholder'=>'Seleccione un vidrio...',
                                             'attr'=>array( 'required'=>'true','class'=>"chzn-select") ))
            ->add('alto')//,'integer',array ('label'=>'Alto (mts)', 'attr'=>array('step'=>'0.01', 'min'=>'0.01', 'formnovalidate'=>'formnovalidate')))
            ->add('ancho')//,'integer',array ('label'=>'Ancho (mts)', 'attr'=>array('step'=>'0.01', 'min'=>'0.01', 'formnovalidate'=>'formnovalidate')))
            ->add('premarco')
            ->add('contramarco')
            ->add('cantidad','integer',array ('label'=>'Cantidad', 'attr'=>array('min'=>'1')))
           
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
