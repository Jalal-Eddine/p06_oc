<?php

namespace App\Form;

use App\Entity\Tricks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TricksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => "Merci de saisir le nom de la figure"
                ]
            ])
            ->add('discription', TextType::class, [
                'label' => 'Discription',
                'attr' => [
                    'placeholder' => "Merci de saisir la discription de la figure"
                ]
            ])
            ->add('grouping', TextType::class, [
                'label' => 'Groupe',
                'attr' => [
                    'placeholder' => "Merci de saisir le groupe"
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);
    }
}
