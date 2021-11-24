<?php

namespace App\Form;

use App\Entity\Themes;
use App\Entity\Chapters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ChaptersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titleChapter', TextType::class, [
                'label' => 'Titre du Chapitre'
            ])
            ->add('pictureChapter', FileType::class, [
                'label' => 'Image du chapitre',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Veuillez entrer un format de document
                   valide',
                    ])
                ],
            ])

            ->add('themes', EntityType::class, [
                'class' => Themes::class,
                'choice_label' => 'titleTheme',
                'label' => 'Thème du chapitre'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chapters::class,
        ]);
    }
}
