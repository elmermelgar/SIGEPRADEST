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
            ->add('fechaNacimiento', 'date', array(
                'widget' => 'single_text',
                // do not render as type="date", to avoid HTML5 date pickers
                'html5' => false,
                'format' => 'dd-MM-yyyy',
                'required' => true))
            ->add('estadoCivil', 'choice', array('choices' => array(
                'Acompañado(a)' => 'Acompañado(a)',
                'Casado(a)' => 'Casado(a)',
                'Divorciado(a)' => 'Divorciado(a)',
                'Separado(a)' => 'Separado(a)',
                'Soltero(a)' => 'Soltero(a)',
                'Viudo(a)' => 'Viudo(a)' ),
                'placeholder' => 'Seleccione una opción...',
                'required' => true))
            ->add('direccionParticular', 'textarea')
            ->add('lugarTrabajo', 'textarea',array(
                'required' => false, 'empty_data' => null
            ))
            ->add('direccionTrabajo', 'textarea', array(
                'required' => false, 'empty_data' => null
            ))
            ->add('telefonoMovil','text', array(
                'required' => false, 'empty_data' => null
            ))
            ->add('telefonoParticular','text', array(
                'required' => false, 'empty_data' => null
            ))
            ->add('telefonoTrabajo','text', array(
                'required' => false, 'empty_data' => null
            ))
            ->add('correo', 'email')
            ->add('guardar', 'submit', array('label' => 'Guardar'));
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
