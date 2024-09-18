<?php

namespace App\Form;

use App\Entity\Horaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HoraireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Jour')
            ->add('heureOuvertureMatin', null, [
                'widget' => 'single_text',
            ])
            ->add('heureFermetureMatin', null, [
                'widget' => 'single_text',
            ])
            ->add('heureOuvertureApresMidi', null, [
                'widget' => 'single_text',
            ])
            ->add('heureFermetureApresMidi', null, [
                'widget' => 'single_text',
            ])
            ->add('ferme')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Horaire::class,
        ]);
    }
}
