<?php

namespace App\Form;

use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero', TextType::class, [
                'required' => true,
                'label' => 'Identifiant de la session',
                'attr' => ['maxlength' => 30],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner l’identifiant de l’offre. *',
                    ]),
                ],
            ])
            ->add('debut', DateType::class, [
                'required' => false,
                'label' => 'Date de début',
            ])
            ->add('fin', DateType::class, [
                'required' => false,
                'label' => 'Date de fin',
            ])
            ->add('etatRecrutement', ChoiceType::class, [
                'choices' => [
                    'Ouvert' => 1,
                    'Fermé' => 2,
                ],
                'placeholder' => 'Choisie une option',
                'required' => true,
                'label' => 'État de recrutement. *',
            ])
            ->add('modalitesParticulieres', TextType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Modalités particulières.',
                'attr' => ['maxlength' => 3000],
            ])
            ->add('garantie', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'Non' => 0,
                    'Oui' => 1
                ],
                'placeholder' => 'Choisie une option',
                'required' => true,
                'label' => 'Garantie *',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez séléctionner la garantie.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
