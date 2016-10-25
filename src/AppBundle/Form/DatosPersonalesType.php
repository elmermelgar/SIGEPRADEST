<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DatosPersonalesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('duiAlumno')
            ->add('nitAlumno')
            ->add('fechaNacimeitno', 'date', array('widget' => 'single_text','format' =>'yyyy-MM-dd'))
            ->add('estadoCivil','choice', array('choices' => array(
                'Acompañado(a)' => 'Acompañado(a)',
                'Casado(a)' => 'Casado(a)',
                'Divorciado(a)' => 'Divorciado(a)',
                'Soltero(a)' => 'Soltero(a)',
                'Viudo(a)' => 'Viudo(a)'
            )))
            ->add('direccionParticular', 'textarea')
            ->add('lugarTrabajo', 'textarea')
            ->add('direccionTrabajo', 'textarea')
            ->add('telefonoMovil')
            ->add('guardar', 'submit', array('label' => 'Guardar'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\DatosPersonales'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_datospersonales';
    }
}
