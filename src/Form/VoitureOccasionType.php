<?php

namespace App\Form;

use App\Entity\VoitureOccasion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureOccasionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prix')
            ->add('anneeMiseEnCirculation', DateType::class, [
                'widget' => 'single_text', // Cela permet d'utiliser un champ de type date HTML5
                'input' => 'datetime', // Stocke la date sous forme d'objet DateTime
                'format' => 'yyyy-MM-dd', // Définir le format
            ])
            ->add('kilometrage')
            ->add('description')
            ->add('imagePrincipale')
            ->add('galerieImages')
            ->add('equipementsOptions');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VoitureOccasion::class,
        ]);
    }
}
