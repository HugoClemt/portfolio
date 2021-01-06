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
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('etudiant', EntityType::class, array('class' => 'App\Entity\Etudiant','choice_label' => 'Id' ))
            ->add('libcourt', TextType::class)
            ->add('descriptif', TextareaType::class)
            ->add('contexte', TextareaType::class)
            ->add('dateDebut', DateType::class, array('input' => 'datetime',
                                                          'widget' => 'single_text',  
                                                          'required' => true,
                                                          'label' =>'Date de début',
                                                          'placeholder' => 'JJ/MM/AAAA'))
            ->add('dateFin', DateType::class, array('input' => 'datetime',
                                                          'widget' => 'single_text', 
                                                          'required' => true,
                                                          'label' =>'Date de fin',
                                                          'placeholder' => 'JJ/MM/AAAA'))
            ->add('environnement', TextType::class)
            ->add('moyen', TextType::class)
            ->add('localisation', EntityType::class, array('class' => 'App\Entity\Localisation','choice_label' => 'Libelle' ))  
            ->add('source', EntityType::class, array('class' => 'App\Entity\Source','choice_label' => 'Libelle' ))
            ->add('cadre', EntityType::class, array('class' => 'App\Entity\Cadre','choice_label' => 'Libelle' ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RP::class,
        ]);
    }
}
