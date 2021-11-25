<?php

namespace App\Form;

use App\Entity\Chapters;
use App\Entity\SubChapters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SubChaptersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titleSubChapter', TextType::class, [
                'label' => 'Titre de la partie'
            ])
            ->add('videoSubChapter', FileType::class, [
                'label' => 'Vidéo ou photo',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                new File([
                // 'maxSize' => '1024k',
               
                ])
                ],
                ])
            ->add('chapters', EntityType::class, [
                'class' => Chapters::class,
                'choice_label' => 'titleChapter',
                'label' => 'Chapitre concerné'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SubChapters::class,
        ]);
    }
}
