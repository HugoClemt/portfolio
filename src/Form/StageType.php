<?php

namespace App\Form;

use App\Entity\Stage;
use App\Entity\Enseignant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomtut')
            ->add('teltut')
            ->add('mailtut')
            ->add('lieu')
            ->add('nbsemaine')
            ->add('nomentreprise')
            ->add('adrentreprise')
            ->add('directeur')
            ->add('codenaf')
            ->add('siret')
            ->add('telentreprise')
            ->add('mailentreprise')
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
            ->add('sujet')
            ->add('horLun', TextType::class, array('attr' => array('placeholder' => '8h - 12h / 14h - 17h' ), 'required' => false))
            ->add('horMar', TextType::class, array('attr' => array('placeholder' => '8h - 12h / 14h - 17h' ), 'required' => false))
            ->add('horMer', TextType::class, array('attr' => array('placeholder' => '8h - 12h / 14h - 17h' ), 'required' => false))
            ->add('horJeu', TextType::class, array('attr' => array('placeholder' => '8h - 12h / 14h - 17h' ), 'required' => false))
            ->add('horVen', TextType::class, array('attr' => array('placeholder' => '8h - 12h / 14h - 17h' ), 'required' => false))
            ->add('horSam', TextType::class, array('attr' => array('placeholder' => '8h - 12h / 14h - 17h' ), 'required' => false))
            ->add('service', TextType::class, array('required' => false))
            ->add('ville')
            ->add('copos')
            ->add('enregistrer', SubmitType::class, array('label' => 'Valider'))
            ->add('enseignant', EntityType::class, array(
                'class' => 'App\Entity\Enseignant',
                'choice_label' => function (Enseignant $enseignant) {
                    return $enseignant->getNom() . ' ' . $enseignant->getPrenom();
                    },));
            
        }
    

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }






}
