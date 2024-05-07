<?php



namespace App\Form;
use App\Entity\Event;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType; // Import EntityType class
use Symfony\Component\Form\Extension\Core\Type\FileType; // Import FileType class
class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('totale')
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
            'data_class' => Ticket::class,
        ]);
    }
}
