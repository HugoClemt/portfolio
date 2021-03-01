<?php

namespace App\Form;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class EtudiantInfoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Formulaire pour afficher les informations d'un étudiant
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('mail', TextType::class)
            ->add('mobile', TextType::class)
            ->add('datenaiss', DateType::class, array('input' => 'datetime',
                                                          'widget' => 'single_text',
                                                          'required' => true,
                                                          'label' =>'date de naissance',
                                                          'placeholder' => 'jj/mm/aaaa'))
            ->add('adrperso', TextType::class)
            
            ->add('enregistrer', SubmitType::class, array('label' => 'Appliquer les modifications'))




        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
