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
            ->add('name', TextType::class)
            ->add('discription')
            ->add('creation_date')
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
                    'groupe 1' => 1,
                    'groupe 2' => 2,
                    'groupe 3' => 3,
                    'groupe 4' => 4
                ],
                'mapped' => false,
                'label' => 'groupe'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);
    }
}
