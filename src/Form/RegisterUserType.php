<?php

namespace App\Form;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse mail',
                'attr' => ['placeholder' => 'Entrez votre adresse mail']
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 10,
                        'minMessage' => 'Votre prénom doit contenir au moins {{ limit }} caractères.'
                    ])
                ],
                'attr' => ['placeholder' => 'Entrez votre prénom']
                
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'attr' => ['placeholder' => 'Entrez votre nom']
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'max' => 30,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères.'
                    ])
                ],

                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'Choisissez votre mot de passe'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmez votre mot de passe',
                    'attr' => [
                        'placeholder' => 'Confirmez votre mot de passe'
                    ]
                ],
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'mapped' => false, // Important si le champ n'est pas directement lié à l'entité
            ])
           
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
                'attr' => ['class' => 'btn btn-success']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints'=>[
                new UniqueEntity([
                    'entityClass' => User::class,
                    'fields' => 'email',
                    'message' => 'Cette adresse mail est déjà utilisée.'
                   
                ])
            ],
            'data_class' => User::class,
        ]);
    }
}
