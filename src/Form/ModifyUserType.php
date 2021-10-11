<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ModifyUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('username', TextType::class, [
                'disabled' => true,
                'label' => 'Username'
            ])
            ->add('email', EmailType::class, [
                'label' => "Votre email"
            ])
            ->add('old_password', PasswordType::class, [
                'mapped' => false,
                'required' => false,
                'label' => "Mon mot de passe actuel",
                'attr' => [
                    'placeholder' => "veuillez saisir votre mot de passe actuel"
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'constraints' => new Length([
                    'min' => 6,
                    'max' => 20
                ]),
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique.',
                'label' => "votre mot de passe",
                'required' => false,
                'first_options' => [
                    'label' => 'Mon nouveau mot de passe',
                    'attr' => [
                        'placeholder' => "Merci de saisir votre nouveau mot de passe"
                    ]
                ],
                'second_options' => [
                    'label' => ' Confirmez votre nouveau mot de passe',
                    'attr' => [
                        'placeholder' => "Merci de confirmer votre nouveau mot de passe"
                    ]
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => "Ajouter votre prénom"
            ])
            ->add('lastname', TextType::class, [
                'label' => "Ajouter votre nom"
            ])
            ->add('photo', TextType::class, [
                'label' => 'Ajouter un lien de votre photo'
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Mettre à jour"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
