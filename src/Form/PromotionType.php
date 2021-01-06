<?php

namespace App\Form;

use App\Entity\Specialite;
use App\Entity\Promotion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class PromotionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $specialites)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('Specialite', EntityType::class, array('class' => 'App\Entity\Specialite','choice_label' => 'Libelle' ))
            ->add('enregistrer', SubmitType::class, array('label' => 'Nouvelle promotion'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Promotion::class,
        ]);
    }
}
