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
use App\Repository\EnseignantRepository;

class SoumettreRPEnseignantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('enseignant', EntityType::class, array('class' => 'App\Entity\Enseignant',
                                                         'choice_label' => 'Nom',
                                                         'placeholder' => 'Choisissez un enseignant',
                                                         
                                                         'query_builder' => function (EnseignantRepository $er) {
                                                            return $er->createQueryBuilder('enseignant')
                                                            ->where('enseignant.matiere IN (:numero)')
                                                            ->setParameter('numero','1');
                                                            },))
            
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
