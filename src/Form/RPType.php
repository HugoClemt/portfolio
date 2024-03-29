<?php


namespace App\Form;

use App\Entity\RP;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class RPType extends AbstractType
{

    //Formulaire pour enregistrer les informations concernant une RP
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libcourt', TextType::class)
            ->add('besoin', TextareaType::class)
            ->add('dateDebut', DateType::class, array('input' => 'datetime',
                                                          'widget' => 'single_text',
                                                          'required' => true,
                                                          'label' =>'date de naissance',
                                                          'placeholder' => 'jj/mm/aaaa'))
             ->add('dateFin', DateType::class, array('input' => 'datetime',
                                                          'widget' => 'single_text',
                                                          'required' => true,
                                                          'label' =>'date de naissance',
                                                          'placeholder' => 'jj/mm/aaaa'))
            ->add('environnement', TextType::class, array('required' => false))
            ->add('moyen', TextType::class, array('required' => false))
            ->add('localisation', EntityType::class, array('class' => 'App\Entity\Localisation','choice_label' => 'Libelle' ))  
            ->add('source', EntityType::class, array('class' => 'App\Entity\Source','choice_label' => 'Libelle' ))
            ->add('niveau', EntityType::class, array('class' => 'App\Entity\Niveau','choice_label' => 'Libelle' ))
            ->add('cadre', EntityType::class, array('class' => 'App\Entity\Cadre','choice_label' => 'Libelle' ))
            ->add('enregistrer', SubmitType::class, array('label' => 'Valider'))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RP::class,
        ]);
    }
}
