<?php

namespace App\Form;

use App\Entity\Forumsponsor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // Import EntityType class
use Symfony\Component\Form\Extension\Core\Type\FileType; // Import FileType class
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class ForumsponsorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('demande')
            ->add('nomEtab')
            ->add('domaine', ChoiceType::class, [
                'label' => 'Domaine',
                'choices' => [
                    'IT' => 'IT',
                    'Marketing' => 'Marketing',
                    'Consulting' => 'Consulting',
                    'Finance' => 'Finance',
                    'Chimie' => 'Chimie',
                    'Civil' => 'Civil',
                    'Autres' => 'Autres',

                ],
                'expanded' => false,
                'multiple' => false,
                
            ])
            ->add('autreDomaine', TextType::class, [
                'label' => 'Autre domaine',
                'required' => false, // Le champ n'est pas obligatoire
            ])
            ->add('tetab', ChoiceType::class, [
                'label' => 'Type d\'établissement',
                'choices' => [
                    'Entreprise' => 'entreprise',
                    'Startup' => 'startup',
                    'Organisme' => 'organisme',
                    'Institution financière' => 'institution_financière',
                ],
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('produit', FileType::class, [
                'label' => 'Image (JPG, PNG, JPEG)',
                'mapped' => false,
                'required' => false,])
            ->add('monatant')
            ->add('numtel')
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forumsponsor::class,
        ]);
    }
}
