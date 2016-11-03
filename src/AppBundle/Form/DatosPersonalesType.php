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
                'format' => 'dd-MM-yyyy'))
            ->add('estadoCivil', 'choice', array('choices' => array(
                'Acompañado(a)' => 'Acompañado(a)',
                'Casado(a)' => 'Casado(a)',
                'Divorciado(a)' => 'Divorciado(a)',
                'Separado(a)' => 'Separado(a)',
                'Soltero(a)' => 'Soltero(a)',
                'Viudo(a)' => 'Viudo(a)'
                ),
                'placeholder' => 'Seleccione una opción...'))
            ->add('direccionParticular', 'textarea')
            ->add('lugarTrabajo', 'textarea')
            ->add('direccionTrabajo', 'textarea')
            ->add('telefonoMovil')
            ->add('telefonoParticular')
            ->add('telefonoTrabajo')
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
