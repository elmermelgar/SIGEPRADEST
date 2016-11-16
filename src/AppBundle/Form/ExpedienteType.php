<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExpedienteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreExp')
            ->add('datosCarrera')
            ->add('genero')
            ->add('paisNacimiento')
            ->add('nacionalidad')
            ->add('fechaNaci','text')
            ->add('duiExp')
            ->add('nitExp')
            ->add('estadoCivilExp')
            ->add('situacionLaboral')
            ->add('tipoEstudiante')
            ->add('direccionExp')
            ->add('deptoRecidencia')
            ->add('municipioRecidencia')
            ->add('telefono')
            ->add('emailExp')
            ->add('fechaTitulacion','date')
            ->add('fechaExpTitulo','date')
            ->add('institucionExp')
            ->add('bachillerato')
            ->add('cambiosCarreraAprob')
            ->add('fechaRegistro','date')
            ->add('idAlumno','entity',array('class'=>'AppBundle\Entity\Alumno','property' =>'idAlumno'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Expediente'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_expediente';
    }
}
