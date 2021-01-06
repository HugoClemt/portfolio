<?php

namespace App\Form;

use App\Entity\Stage;
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
            ->add('etudiant',EntityType::class, array('class'=> 'App\Entity\Etudiant', 'choice_label' => 'nom'))
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
           // ->add('faxentreprise')
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
            ->add('horLun')
            ->add('horMar')
            ->add('horMer')
            ->add('horJeu')
            ->add('horVen')
            ->add('horSam')
            ->add('ville')
             ->add('copos');

            
            //->add('enseignant' ,EntityType::class, array('class'=>'App\Entity\Enseignant','choice_label' =>'id' ))

        }
    

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }






}
