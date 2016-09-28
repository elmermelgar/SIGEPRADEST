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
            ->add('idUi', 'entity', array('class' => 'AppBundle\Entity\Usuario',
                'query_builder' => function ($er) use ($options) {
                    $qb = $er->createQueryBuilder('u');
                    $qb->where('u.nomusuario =\'' . $options["user"] . "'");
                    return $qb;
                }, 'choice_label' =>
                    function ($idUi) {
                        return $idUi->getNomusuario();
                    }
            ))
            ->add('idDhe', 'entity', array('class' => 'AppBundle\Entity\DetalleHorario',
                'query_builder' => function ($er) use ($options) {
                    $qb = $er->createQueryBuilder('u');
                    // con este metodo agregamos unicamente los cirterios que deseamos para que se muestren
                    //  echo   $qb->getDql();  con esto vemos la DQL que se esta enviando , no se puede cambiar tan facilmente
                    $qb->where('u.ocupado = false')
                        ->orderBy('u.ocupado', 'ASC');
                    return $qb;
                }, 'choice_label' =>
                    function ($idDhe) {
                        return $idDhe->getFechaDhe()->format('Y-m-d');
                    }
// para elegir el texto que se mostrara en los label que estaran presentes en el fomulario
            ))
            ->add('comentarioCita', 'textarea');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Cita',
            'user' => null,
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
