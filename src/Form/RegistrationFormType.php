<?php

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Entrez votre prénom',
                    'onblur' => 'validateFirstName(this.value)', // validation côté client
                    'required' => 'required',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide.',
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Za-zÀ-ÖØ-öø-ÿ\-]+$/',
                        'message' => 'Le prénom ne peut contenir que des lettres et un trait d\'union.',
                    ]),
                ],
            ])
            
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Entrez votre nom',
                    'onblur' => 'validateLastName(this.value)', // validation côté client 
                    'required' => 'required',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide.',
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Za-zÀ-ÖØ-öø-ÿ\-]+$/',
                        'message' => 'Le nom ne peut contenir que des lettres et un trait d\'union.',
                    ]),
                ],
            ])

            ->add('tel', TelType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => '02 12 34 56 78',
                    'onblur' => 'validateTel(this.value)', // validation côté client
                    'required' => 'required',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide.',
                    ]),
                    new Regex([
                        'pattern' => '/^0[0-9]{9}$/',
                        'message' => 'Le numéro de téléphone doit commencer par 0 et contenir 10 chiffres.',
                    ]),
                ],
            ])
            //
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Entrez votre adresse e-mail',
                    'onblur' => 'validateEmail(this.value)', // validation côté client
                    'required' => 'required',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide.',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                        'message' => 'L\'adresse e-mail n\'est pas valide.',
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions.',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class,[
                'type' => PasswordType::class,
                'mapped' => false,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'Entrez votre mot de passe',
                        'onblur' => 'validatePassword(this.value)', // validation côté client
                        'required' => 'required',
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe',
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'Confirmez votre mot de passe',
                        'onblur' => 'validatePassword(this.value)', // validation côté client
                        'required' => 'required',
                    ],
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le mot de passe doit contenir au moins 8 caractères, dont au moins une majuscule, un chiffre et un symbole.',
                    ]),
                    new Length([
                        'min' => 8,
                        'max' => 4096,
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&+=]).+$/',
                        'message' => 'Le mot de passe doit contenir au moins une lettre majuscule, un chiffre, et un symbole.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
