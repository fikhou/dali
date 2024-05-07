<?php

namespace App\Form;

// src/Form/EventType.php

use App\Entity\Event;
use App\Entity\Entreprise;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // Import EntityType class
use Symfony\Component\Form\Extension\Core\Type\FileType; // Import FileType class

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomEvent')
            ->add('datedebut')
            ->add('datefin')
            
            ->add('entreprise', EntityType::class, [
                'class' => Entreprise::class, // Assuming Entreprise is the related entity
                'choice_label' => 'nomentreprise', // Customize this based on your Entreprise entity
                'placeholder' => 'Select an Entreprise', // Optional placeholder
            ])
            ->add('image', FileType::class, [
                'label' => 'Image (JPG, PNG, JPEG)',
                'mapped' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
