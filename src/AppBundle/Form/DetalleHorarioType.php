<?php

namespace AppBundle\Form;

use Proxies\__CG__\AppBundle\Entity\HorarioEntrevista;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DetalleHorarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idHe','entity',array('class'=>'AppBundle\Entity\HorarioEntrevista','property' =>'idHe'))
            ->add('horaDhe','time')
            ->add('fechaDhe','date',array('widget' => 'single_text','format' =>'yyyy-MM-dd'))
            ->add('ocupado')


        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\DetalleHorario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_detallehorario';
    }
}
