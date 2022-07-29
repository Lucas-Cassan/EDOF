<?php

namespace App\Form;

use App\Entity\Action;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ActionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero', TextType::class, [
                'required' => true,
                'label' => 'Numéro de l’action de formation *',
                'attr' => ['maxlength' => 30],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner le numéro de l’action de formation. *',
                    ]),
                ],
            ])
            ->add('niveauEntreeObligatoire', ChoiceType::class, [
                'choices' => [
                    'Non' => 0,
                    'Oui' => 1,
                ],
                'placeholder' => 'Choisie une option',
                'required' => true,
                'label' => 'Niveau d’entrée obligatoire *',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez séléctionner le niveau d’entrée obligatoire. *',
                    ]),
                ],
            ])
            ->add('modalitesEnseignement', ChoiceType::class, [
                'choices' => [
                    'Formation entièrement présentielle' => 0,
                    'Formation mixte' => 1,
                    'Formation entièrement à distance' => 2,
                ],
                'placeholder' => 'Choisie une option',
                'required' => true,
                'label' => 'Modalités d’enseignement *',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez séléctionner les modalités d’enseignement. *',
                    ]),
                ],
            ])
            ->add('conditionsSpecifiques', TextareaType::class, [
                'required' => false,
                'label' => 'Conditions spécifiques.',
                'attr' => ['maxlength' => 3000],
            ])
            ->add('modalitesEntreesSorties', ChoiceType::class, [
                'choices' => [
                    'A dates fixes' => 0,
                    'Permanentes (sans dates fixes)' => 1,

                ],
                'placeholder' => 'Choisie une option',
                'required' => true,
                'label' => 'Modalités d’entrées et de sorties *',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez séléctionner les modalités d’entrées et de sorties. *',
                    ]),
                ],
            ])
            ->add('urlWeb', TextareaType::class, [
                'required' => false,
                'label' => 'Adresse du site web de l’action de formation.',
                'attr' => ['maxlength' => 400],
            ])
            ->add('restauration', TextareaType::class, [
                'required' => false,
                'label' => 'Informations sur la restauration.',
                'attr' => ['maxlength' => 250],
            ])
            ->add('hebergement', TextareaType::class, [
                'required' => false,
                'label' => 'Informations sur l’hébergement.',
                'attr' => ['maxlength' => 250],
            ])
            ->add('transport', TextareaType::class, [
                'required' => false,
                'label' => 'Informations sur les transports.',
                'attr' => ['maxlength' => 250],
            ])
            ->add('langueFormation', ChoiceType::class, [
                'choices' => [
                    'Français' => 'FR',
                    'Anglais' => 'EN',
                    'Allemand' => 'DE',
                    'Espagnol' => 'ES',
                    'Italien' => 'IT',
                ],
                'placeholder' => 'Choisie une option',
                'required' => true,
                'label' => 'Langue de la formation *',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez séléctionner la langue de la formation. *',
                    ]),
                ],
            ])
            ->add('modalitesRecrutement', TextareaType::class, [
                'required' => false,
                'label' => 'Modalités de recrutement.',
                'attr' => ['maxlength' => 3000],
            ])
            ->add('modalitesPedagogiques', TextareaType::class, [
                'required' => false,
                'label' => 'Modalités pédagogiques.',
                'attr' => ['maxlength' => 200],
            ])
            ->add('codePerimetreRecrutement', ChoiceType::class, [
                'choices' => [
                    'Commune' => 1,
                    'Département' => 2,
                    'Région' => 3,
                    'Interrégion' => 4,
                    'National' => 5,
                    'International' => 6,
                    'Autres' => 7,
                ],
                'placeholder' => 'Choisie une option',
                'required' => false,
                'label' => 'Code de périmètre de recrutement.',
            ])
            ->add('infosPerimetreRecrutement', TextType::class, [
                'required' => false,
                'label' => 'Informations sur le périmètres de recrutement.',
                'attr' => ['maxlength' => 50],
            ])
            ->add('nombreHeuresCentre', NumberType::class, [
                'required' => false,
                'label' => 'Nombres d’heures maximum en centre de formation.',
                'attr' => ['maxlength' => 5],
            ])
            ->add('nombreHeuresEntreprise', NumberType::class, [
                'required' => false,
                'label' => 'Nombres d’heures maximum en entreprise.',
                'attr' => ['maxlength' => 5],
            ])


            //LES EXTRAS FORMATION
            ->add('modalitesHandicap', TextareaType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Modalités pédagogiques adaptées aux personnes en situation de hancicap.',
                'attr' => ['maxlength' => 3000],
            ])
            ->add('infoAdmission', TextareaType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Information sur l’admission.',
                'attr' => ['maxlength' => 250],
            ])
            ->add('codeModalitesAdmission', ChoiceType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Codes sur les modalités d’admission. *',
                'choices'  => [
                    'Admission sur dossier' => '92002',
                    'Admission sur concours' => '92003',
                    'Admission après entretien' => '92005',
                    'Admission après test' => '92007',
                    'Admission après visite méicale' => '92009',
                    'Plusieurs modalités possibles' => '99998',
                    'Admission sans disposition particulière' => '99999',
                ],
                'expanded'  => true,
                'multiple'  => true,
            ])
            ->add('codeGfe', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'Commune' => 1,
                    'Département' => 2,
                    'Région' => 3,
                    'Interrégion' => 4,
                    'National' => 5,
                    'International' => 6,
                    'Autres' => 7,
                ],
                'placeholder' => 'Choisie une option',
                'required' => false,
                'label' => 'Code : Groupe emploi de formation.',
            ])
            ->add('codeTypeHoraire', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'A horaires fixes' => 1,
                    'Sans horaires fixes' => 2,
                    'Mixte' => 3,
                ],
                'placeholder' => 'Choisie une option',
                'required' => false,
                'label' => 'Horaire de la formation.',
            ])
            ->add('codeRythmeFormation', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'En journée' => 1,
                    'En soirée' => 2,
                    'En semaine' => 3,
                    'Le week-end' => 4,
                    'Temps plein' => 5,
                    'Temps partiel' => 6,
                    'Plusieurs rythmes' => 7
                ],
                'placeholder' => 'Choisie une option',
                'required' => true,
                'label' => 'Rythme de la formation. *',
                'expanded'  => true,
                'multiple'  => true,
            ])
            ->add('fraisAnpec', NumberType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Frais ANPEC. (10 chiffres + 2 décimales : anpec = additionnel non pris en charge.)',
                'attr' => ['maxlength' => 13],
            ])
            ->add('fraisCertifInclusFraisAnpec', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0
                ],
                'placeholder' => 'Choisie une option',
                'required' => true,
                'label' => 'Frais certification inclus les frais ANPEC. *',
            ])
            ->add('detailFraisAnpec', TextareaType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Détail frais ANPEC.',
                'attr' => ['maxlength' => 3000],
            ])
            ->add('codeModeleEconomique', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'Assiduité: calcul en heure, demi-journée, jour' => 1,
                    'Forfait: calcul forfaitaire' => 2
                ],
                'placeholder' => 'Choisie une option',
                'required' => true,
                'label' => 'Code modèle économique ou construction tarifaire. *',
            ])
            ->add('autresServices', TextareaType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Autres services.',
                'attr' => ['maxlength' => 255],
            ])
            ->add('tauxTva', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'Net de TVA' => "0.0",
                    'Soumis au taux de 5,5%' => "5.5",
                    "Soumis au taux de 20%" => "20.0"
                ],
                'placeholder' => 'Choisie une option',
                'required' => true,
                'label' => 'Taux TVA. *',
            ])
            ->add('fraisHt', NumberType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Frais H.T *',
                'attr' => ['maxlength' => 13],
            ])
            ->add('fraisTtc', NumberType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Frais TTC. *',
                'attr' => ['maxlength' => 13],
            ])
            ->add('existencePrerequis', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0
                ],
                'placeholder' => 'Choisie une option',
                'required' => true,
                'label' => 'Conditions spécifiques ou prérequis à l’inscription à la formation. *',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Action::class,
        ]);
    }
}
