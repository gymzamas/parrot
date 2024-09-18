<?php

// src/Form/VoitureOccasionFilterType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class VoitureOccasionFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('minPrix', NumberType::class, [
                'required' => false,
                'label' => 'Prix minimum',
            ])
            ->add('maxPrix', NumberType::class, [
                'required' => false,
                'label' => 'Prix maximum',
            ])
            ->add('minKilometrage', IntegerType::class, [
                'required' => false,
                'label' => 'Kilométrage minimum',
            ])
            ->add('maxKilometrage', IntegerType::class, [
                'required' => false,
                'label' => 'Kilométrage maximum',
            ])
            ->add('anneeMiseEnCirculation', IntegerType::class, [
                'required' => false,
                'label' => 'Année de mise en circulation',
            ])
            ->add('Rechercher', SubmitType::class);
    }
}
