<?php

namespace App\Form;

use App\Entity\VoitureOccasion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureOccasionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prix')
            ->add('anneeMiseEnCirculation', null, [
                'widget' => 'single_text',
            ])
            ->add('kilometrage')
            ->add('description')
            ->add('imagePrincipale')
            ->add('galerieImages')
            ->add('equipementsOptions')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VoitureOccasion::class,
        ]);
    }
}
