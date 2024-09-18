<?php

// src/Form/TemoignageType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class TemoignageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('commentaire', TextareaType::class, [
                'label' => 'Commentaire',
            ])
            ->add('note', IntegerType::class, [
                'label' => 'Note (sur 5)',
                'attr' => ['min' => 1, 'max' => 5],
            ])
            ->add('Envoyer', SubmitType::class);
    }
}
