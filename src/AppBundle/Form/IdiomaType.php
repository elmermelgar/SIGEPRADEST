<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IdiomaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idioma')
            ->add('comprensionAuditiva')
            ->add('expresionOral')
            ->add('expresionEscrita')
            ->add('leguaMaterna')
            ->add('idCurriculum','entity',array('class'=>'AppBundle\Entity\Curriculum','property' =>'idCurriculum'))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Idioma'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_idioma';
    }
}
