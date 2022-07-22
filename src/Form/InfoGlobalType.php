<?php

namespace App\Form;

use App\Entity\InfoGlobal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class InfoGlobalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('accesHandicapes', TextareaType::class, [
                'required' => true,
                'label' => 'Accès handicapés *',
                'attr' => ['maxlength' => 3000],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner les informations sur l’accésibilité pour les personnes en cas de handicap',
                    ]),
                ],
            ])

            //Informations addre
            ->add('numero', TextType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Titre de l’adresse *',
                'attr' => ['maxlength' => 30],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un titre pour l’adresse.',
                    ]),
                ],
            ])
            ->add('nomOrganisme', TextType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Nom de l’organisme *',
                'attr' => ['maxlength' => 30],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner le nom de l’organisme.',
                    ]),
                ],
            ])
            ->add('nom', TextType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Nom *',
                'attr' => ['maxlength' => 50],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre nom.',
                    ]),
                ],
            ])

            ->add('prenom', TextType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Prénom *',
                'attr' => ['maxlength' => 50],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre prénom.',
                    ]),
                ],
            ])
            ->add('Ville', TextType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Ville *',
                'attr' => ['maxlength' => 50],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre ville.',
                    ]),
                ],
            ])
            ->add('cp', NumberType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Code postal *',
                'attr' => ['maxlength' => 5],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre code postal.',
                    ]),
                ],
            ])
            ->add('numeroVoie', NumberType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Numéro de voie *',
                'attr' => ['maxlength' => 4],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre numéro de voie.',
                    ]),
                ],
            ])
            ->add('natureVoie', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'Rue' => 'RUE',
                ],
                'placeholder' => 'Choisie une option',
                'required' => true,
                'label' => 'Nature de la voie *',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez séléctionner la nature de la voie.',
                    ]),
                ],
            ])
            ->add('libelleVoie', TextType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Libellé de voie *',
                'attr' => ['maxlength' => 32],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre libellé de voie.',
                    ]),
                ],
            ])
            ->add('telfix', TextType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Téléphone fixe *',
                'attr' => ['maxlength' => 25],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre numéro de téléphone fixe.',
                    ]),
                ],
            ])
            ->add('email', TextType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Adresse mail *',
                'attr' => ['maxlength' => 160],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre adresse mail.',
                    ]),
                ],
            ])
            ->add('siret', TextType::class, [
                'required' => true,
                'label' => 'SIRET *',
                'attr' => ['maxlength' => 14],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre numéro de siret.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InfoGlobal::class,
        ]);
    }
}
