<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CitaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idUi', 'entity',array('class'=>'AppBundle\Entity\Usuario','property'=>'nombre'))
            ->add('idDhe','entity',array('class'=>'AppBundle\Entity\DetalleHorario','choice_label' =>
                function ($idDhe) {return $idDhe->getFechaDhe()->format('Y-m-d')." - ".$idDhe->getHoraDhe()->format('Y-m-d') ;  }
            ))
            ->add('comentarioCita','textarea')

        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Cita'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_cita';
    }
}
