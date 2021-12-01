<?php

namespace App\Form;

use App\Entity\Chapters;
use App\Entity\Exercices;
use App\Entity\SubChapters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ExercicesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titleExercise', TextType::class, [
                'label' => 'Titre de l\'exercice'
            ])
            ->add('descriptionExercice', HiddenType::class)
            ->add('subChapters', EntityType::class, [
                'class' => SubChapters::class,
                'choice_label' => 'titleSubChapter',
                'label' => 'Sous chapitre concerné'
            ])
            ->add('Envoyer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exercices::class,
        ]);
    }
}
