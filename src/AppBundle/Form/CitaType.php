<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CitaType extends AbstractType
{
private  $isEdit=false;

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
                   if( $this->isEdit){
                       // de esta manera podemos decir que muestre todas las variables, las encontraremos
//                       $qb->where('u.ocupado = true');
                        }
                    else {
                        $qb->where('u.ocupado = false');
                    }
                    $qb ->orderBy('u.ocupado', 'ASC');
                    return $qb;
                }, 'choice_label' =>
                    function ($idDhe) {

                        $fechasDisponible = $idDhe->getFechaDhe()->format('Y-m-d');
                        $fechasDisponible= $fechasDisponible." - ". $idDhe->getHoraDhe()->format('h:i A');
                        return $fechasDisponible;
                    }
// para elegir el texto que se mostrara en los label que estaran presentes en el fomulario
            ))
            ->add('comentarioCita', 'textarea')
            ->add('idCurso','entity', array('class' => 'AppBundle\Entity\Curso'
            , 'choice_label' =>
                    function ($idCurso) {
                        return $idCurso->getNombreCurso();
                    }

            ));
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



    /**
     * @return mixed
     */
    public function getIsEdit()
    {
        return $this->isEdit;
    }

    /**
     * @param mixed $isEdit
     */
    public function setIsEdit($isEdit)
    {
        $this->isEdit = $isEdit;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */


}
