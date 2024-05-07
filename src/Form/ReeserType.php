<?php

namespace App\Form;

use App\Entity\Reeser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Event;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // Import EntityType class

class ReeserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('nomreser')
            ->add('date')
            ->add('event', EntityType::class, [
                'class' => Event::class, // Assuming Entreprise is the related entity
                'choice_label' => 'nomevent', // Customize this based on your Entreprise entity
                'placeholder' => 'Select an event', // Optional placeholder
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reeser::class,
        ]);
    }
}
