<?php

namespace App\Form;

use App\Entity\Tapas;
use App\Entity\Ingredient;
use App\Entity\Categorie;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TapaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom',TextType::class,  array('attr' => array('class' => 'form-control')))
        ->add('description',TextareaType::class,  array('attr' => array('class' => 'form-control')))
                
        ->add('ingredient',EntityType::class, array(  'label' => 'Composer votre plat','class' => Ingredient::class,'multiple'=>true))
         ->add('categorie',EntityType::class, array('class' => Categorie::class))         
        ->add('photo', FileType::class,array('attr' => array('onchange' => 'onChange(event)')))
                
        ->add('date_de_creation',DateType::class,[
                'label' => 'date de création ',
                 'widget' => 'single_text', 
              ])           
//                
//        ->add('top')
        ->add('creer',SubmitType::class);
    }
    
    
     public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Tapas::class,
        ]);
    }


}
