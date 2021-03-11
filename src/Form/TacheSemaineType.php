<?php

namespace App\Form;

use App\Entity\TacheSemaine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TacheSemaineType extends AbstractType
{
    //Formulaire pour enregistrer les taches pour une semaine de stage
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('domaine', EntityType::class, array('class' => 'App\Entity\DomaineTaches', 'choice_label' => 'libelle'))
            ->add('jour', EntityType::class, array('class' => 'App\Entity\Jour','choice_label' => 'libelle' ))
            ->add('ajouter', SubmitType::class, array('label' => 'Valider'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TacheSemaine::class,
            'csrf_protection' => false,
        ]);
    }
}
