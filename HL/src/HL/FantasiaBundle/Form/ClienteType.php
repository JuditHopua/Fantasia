<?php

namespace HL\FantasiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClienteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
             ->add('nombre','text',array('label'=>'Nombre',
                                        'pattern'=>"[a-zA-ZÑñá-úÁ-Ú ]+"))

            ->add('apellido','text',array('label'=>'Apellido',
                                        'pattern'=>"[a-zA-ZÑñá-úÁ-Ú]+"))
            ->add('email')
            ->add('telefono','text',array('label'=>'Teléfono',
                                        'pattern'=>"[0-9()-]+"))
            ->add('domicilio')
           ->add('observaciones','text',array('label'=>'Observaciones',
                                        'required'=>false))
          //  ->add('presupuestos')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HL\FantasiaBundle\Entity\Cliente'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hl_fantasiabundle_cliente';
    }
}
