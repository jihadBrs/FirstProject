<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
        ->add('fullName', TextType::class, [
            'attr' => ['class' => 'form-control', 'placeholder' => 'Full Name *']
        ])
        ->add('email', EmailType::class, [
            'attr' => ['class' => 'form-control', 'placeholder' => 'Full Name *']
        ])
        ->add('plainPassword', PasswordType::class, [
            // instead of being set onto the object directly,
            // this is read and encoded in the controller
            'mapped' => false,
            'attr' => ['class' => 'form-control','placeholder' => 'Password *','autocomplete' => 'new-password'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a password',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Your password should be at least {{ limit }} characters',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
        ])
        ->add('userType', ChoiceType::class, [
            'choices'  => [
                'Enseignant' => 'enseignant',
                'Étudiant' => 'etudiant',
            ],
            'expanded' => false,
            'multiple' => false,
            'label' => 'Vous êtes',
        ])
        ->add('agreeTerms', CheckboxType::class, [
            'mapped' => false,
            'attr' => ['class' => 'form-control'],
            'constraints' => [
                new IsTrue([
                    'message' => 'You should agree to our terms.',
                ]),
            ],
        ])
        ->add('save', SubmitType::class, [
            'attr' => ['class' => 'btn btn-primary m-2'],
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