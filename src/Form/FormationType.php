<?php

namespace App\Form;

use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero', TextType::class, [
                'required' => true,
                'label' => 'Identifiant de l’offre',
                'attr' => ['maxlength' => 30],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner l’identifiant de l’offre. (max 30 caractères)',
                    ]),
                ],
            ])
            ->add('intituleFormation', TextType::class, [
                'required' => true,
                'label' => 'Intitulé de la formation',
                'attr' => ['maxlength' => 255],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner l’intitulé de la formation. (max 255 caractères)',
                    ]),
                ],
            ])
            ->add('objectifFormation', TextareaType::class, [
                'required' => true,
                'label' => 'Objectif de la formation',
                'attr' => ['maxlength' => 3000],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner l’objectif de la formation. (max 3000 caractères)',
                    ]),
                ],
            ])
            ->add('resultatsAttendus', TextareaType::class, [
                'required' => true,
                'label' => 'Résultats attendus',
                'attr' => ['maxlength' => 3000],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner les résultats attendus. (max 3000 caractères)',
                    ]),
                ],
            ])
            ->add('contenuFormation', TextareaType::class, [
                'required' => true,
                'label' => 'Contenu de la formation',
                'attr' => ['maxlength' => 3000],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner le contenu de la formation. (max 3000 caractères)',
                    ]),
                ],
            ])
            ->add('parcoursDeFormation', ChoiceType::class, [
                'choices' => [
                    '96213 - Collectif' => 1,
                    '96211 - Individualisé' => 2,
                    '96212 - Modulaire' => 3,
                    '96214 - Mixte' => 4,
                ],
                'placeholder' => 'Choisie une option',
                'required' => true,
                'label' => 'Type de parcours de formation',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez séléctionner le type de parcours de formation.',
                    ]),
                ],
            ])
            ->add('objectifGeneralFormation', ChoiceType::class, [
                'choices' => [
                    'Perfectionnement, élargissement des compétences' => 2,
                    'Création d’entreprise' => 4,
                    'Remise à niveau, maîtrise des savoirs de base, initiation' => 5,
                    'Certification' => 6,
                    'Professionnalisation' => 7,
                    'Préparation à la qualification' => 8,
                    '(Re)mobilisation, aide à l’élaboration de projet professionnel' => 9,
                ],
                'placeholder' => 'Choisie une option',
                'required' => true,
                'label' => 'Objectif général de formation',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez séléctionner l’objectif général de formation.',
                    ]),
                ],
            ])

            //CODE CERTIF IFNO  Après le 8 Sept 2022
            /*   ->add('certifInfo', ChoiceType::class, [
                'choices' => [
                    'Bilan de compétences' => 'CPF202',
                    'Validation des Acquis de l\'Expérience (VAE)' => 'CPF200',
                    'Accompagnement à la création-reprise d\'entreprise' => 'CPF203',
                    'Permis de conduire catégorie B' => 'CPF206',
                    'Permis de conduire catégorie C' => 'CPF210',
                    'Permis de conduire catégorie C1' => 'CPF211',
                    'Permis de conduire catégorie C1E' => 'CPF212',
                    'Permis de conduire catégorie CE' => 'CPF213',
                    'Permis de conduire catégorie D' => 'CPF214',
                    'Permis de conduire catégorie D1' => 'CPF215',
                    'Permis de conduire catégorie D1E' => 'CPF216',
                    'Permis de conduire catégorie DE' => 'CPF217'
                ],
                'placeholder' => 'Choisie une option',
                'required' => true,
                'label' => 'Code RNCP/RS/CPF',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez séléctionner le code de l\'offre.',
                    ]),
                ],
            ]) */
            ->add('certifInfo', TextType::class, [
                'required' => true,
                'label' => 'Code RNCP/RS/CPF',
                'attr' => ['maxlength' => 255],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un code Code RNCP/RS/CPF.',
                    ]),
                ],
            ])
            ->add('extraResumeContenu', TextareaType::class, [
                'required' => true,
                'label' => 'Résumer du contenu de la formation',
                'attr' => ['maxlength' => 255],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner le résumé du contenu de la formation. (max 255 caractères)',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
