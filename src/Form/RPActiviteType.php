<?php

namespace App\Form;

use App\Entity\RPActivite;
use App\Entity\Activite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class RPActiviteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('activite', EntityType::class, array(
                'class' => 'App\Entity\Activite',
                'choice_label' => function (Activite $activite) {
                    return $activite->getCode() . ' - ' . $activite->getLibelle();
                },
                'attr' => array(
                    'class' => 'form',
                    'size' => 18,
                    )
            ))


            ->add('commentaire', TextareaType::class,)

            




            ->add('enregistrer', SubmitType::class, array('label' => 'Valider'));

            

        }
    

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RPActivite::class,
        ]);
    }








}
