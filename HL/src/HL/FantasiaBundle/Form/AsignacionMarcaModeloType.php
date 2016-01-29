<?php

namespace HL\FantasiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\File\File;

class AsignacionMarcaModeloType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
			->add('modelo','entity',array(   'label'=>'Modelo',
                                                'class'=>'FantasiaBundle:Modelo',
												'query_builder' => function(\HL\FantasiaBundle\Entity\ModeloRepository $modelo) {
																 return $modelo->createQueryBuilder('m')
																->orderBy('m.nombre', 'ASC');
																},
                                                'property'=>'nombre',
												'placeholder'=>'Seleccione un modelo...',
                                                'attr'=>array( 'required'=>'true','class'=>"chzn-select") ))
            ->add('marca','entity',array(   'label'=>'Marcas',
                                                'class'=>'FantasiaBundle:Marca',
												'query_builder' => function(\HL\FantasiaBundle\Entity\MarcaRepository $marca) {
																 return $marca->createQueryBuilder('m')
																->orderBy('m.nombre', 'ASC');
																},
                                                'property'=>'nombre',
												'placeholder'=>'Seleccione una marca...',
                                                'attr'=>array( 'required'=>'true','class'=>"chzn-select") ))
            ->add('precioPremarcoML','money',array('label'=>'Precio Premarco ML', 'currency'=>'ARS',
													'attr'=>(array('placeholder'=>'0.00','pattern'=>"[0-9]|(.|,)+([0-9][0-9]?)?"))))
            ->add('precioContramarcoML','money',array('label'=>'Precio Contramarco ML', 'currency'=>'ARS',
													'attr'=>(array('placeholder'=>'0.00','pattern'=>"[0-9]|(.|,)+([0-9][0-9]?)?"))))
            ->add('precioxML','money',array('label'=>'Precio ML', 'currency'=>'ARS',
													'attr'=>(array('placeholder'=>'0.00','pattern'=>"[0-9]|(.|,)+([0-9][0-9]?)?"))))
            ->add('descripcion','text',array('label'=>'Descripción',
                                        'required'=>false))
			
			
            
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
