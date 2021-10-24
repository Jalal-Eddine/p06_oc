<?php

namespace App\Form;

use App\Entity\Tricks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TricksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            ->add('description')
            ->add('images', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add('video', TextType::class, [
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => "Merci d'entré un lien de partage vidéo"
                ]
            ])
            ->add('group', ChoiceType::class, [
                'choices' => [
                    'Les grabs' => 1,
                    'Les rotations' => 2,
                    'Les flips' => 3,
                    'Les rotations désaxées' => 4,
                    'Les slides' => 5,
                    'Les one foot tricks' => 6,
                    '	
                    Old school' => 7
                ],
                'mapped' => false,
                'label' => 'groupe',
                'attr' => [
                    'class' => "form-control"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);
    }
}
