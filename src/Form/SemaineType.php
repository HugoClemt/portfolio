<?php

namespace App\Form;

use App\Entity\SemaineStage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SemaineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numSemaine')
            ->add('apprentissage', TextareaType::class, array('required' => false))
            ->add('bilan', TextareaType::class, array('required' => false))
            ->add('enregistrer', SubmitType::class, array('label' => 'Enregister'))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SemaineStage::class,
            'csrf_protection' => false,
        ]);
    }
}
