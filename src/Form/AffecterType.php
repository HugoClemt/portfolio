<?php

namespace App\Form;

use App\Entity\Stage;
use App\Entity\Enseignant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\EnseignantRepository;

class AffecterType extends AbstractType
{

    //Formulaire pour affecter un enseignant a un stage
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('enseignant', EntityType::class, array('class' => 'App\Entity\Enseignant',
            'placeholder' => 'Choisissez un enseignant',
            'choice_label' => function (Enseignant $enseignant) {
                return $enseignant->getPrenom() . ' ' . $enseignant->getNom();
            },
            'query_builder' => function (EnseignantRepository $er) {
                return $er->createQueryBuilder('enseignant')
                ->AddOrderBy('enseignant.nom', 'asc')
                ->where('enseignant.matiere is NOT NULL');
            },
            ))
            ->add('affecter', SubmitType::class, array('label' => 'Affecter'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
