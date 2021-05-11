<?php

namespace App\Form;
use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReservationType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('user',TextType::class,array('mapped' => false,'data'=>$options['user'],
           'attr' => array('class' => 'form-control','readonly' => 'true')))
          ->add('datereservation', DateType::class,[
                'label' => 'date de reservation ',
                 'widget' => 'single_text', 
              ])           
        ->add('nombrepersonnes',IntegerType::class,  array('attr' => array('class' => 'form-control')))
        ->add('observation',TextareaType::class,  array('attr' => array('class' => 'form-control')))
        ->add('Reserver',SubmitType::class,  array('attr' => array('class' => 'form-btn btn-primary')));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Reservation::class,
            'user'=>''
        ));
    }

}
