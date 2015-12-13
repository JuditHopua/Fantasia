<?php

namespace HL\FantasiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AsignacionMarcaModeloType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('modelos','entity',array(   'label'=>'Modelo: ',
                                                'class'=>'FantasiaBundle:Modelo',
                                                'property'=>'nombre',
                                                'attr'=>array( 'required'=>'true','class'=>"chzn-select") ))
            ->add('marcas','entity',array(   'label'=>'Marcas: ',
                                                'class'=>'FantasiaBundle:Marca',
                                                'property'=>'nombre',
                                                'attr'=>array( 'required'=>'true','class'=>"chzn-select") ))
            ->add('precioPremarcoML')
            ->add('precioContramarcoML')
            ->add('precioxML')
            ->add('descripcion')
			->add('file')
            //->add('carpinterias')
			
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HL\FantasiaBundle\Entity\AsignacionMarcaModelo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hl_fantasiabundle_asignacionmarcamodelo';
    }
}
