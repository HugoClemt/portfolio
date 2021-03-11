<?php

namespace App\Form;

use App\Entity\Enseignant;
use App\Entity\Matiere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
class EnseignantInfoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Formulaire pour afficher les informations d'un enseignant
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('mail', TextType::class)
            ->add('matiere', EntityType::class, array(
                'placeholder' => 'Choisissez votre matière',
                'class' => 'App\Entity\Matiere',
                'choice_label' => function (Matiere $matiere) {
                    return $matiere->getLibelle();
                },
            ))
 
            ->add('enregistrer', SubmitType::class, array('label' => 'Appliquer les modifications'))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Enseignant::class,
        ]);
    }
}
