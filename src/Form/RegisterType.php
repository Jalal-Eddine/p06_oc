<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => "votre nom d'utilisateur",
                'constraints' => new Length(20, 2),
                'attr' => [
                    'placeholder' => "Merci de saisir votre nom d'utilisateur"
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => "votre email",
                'constraints' => new Length(60, 2),
                'attr' => [
                    'placeholder' => "Merci de saisir votre email"
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => new Length(6, 2),
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique.',
                'label' => "votre mot de passe",
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => "Merci de saisir votre mot de passe"
                    ]
                ],
                'second_options' => [
                    'label' => ' Confirmez votre mot de passe',
                    'attr' => [
                        'placeholder' => "Merci de confirmer votre mot de passe"
                    ]
                ]
            ])
            // ->add('password_confirm', PasswordType::class, [
            //     'label' => "confirmer mot de passe",
            //     'mapped' => false,
            //     'attr' => [
            //         'placeholder' => "confirmer votre mot de passe"
            //     ]
            // ])
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
