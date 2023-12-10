<?php

namespace App\Form;

use DateTime;
use App\Entity\Voyage;
use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class ReservationType extends AbstractType
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentRoute = $this->requestStack->getCurrentRequest()->get('_route');

        $builder
        ->add('nom',null, [
            'label' => 'Nom et prenom',
            'attr' => ['class' => 'form-control bg-transparent'],
        ])
        ->add('email',null, [
            'attr' => ['class' => 'form-control bg-transparent'],
        ])
        ->add('telephone',null, [
            'attr' => ['class' => 'form-control bg-transparent'],
        ])
          ->add('date', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control bg-transparent'],
                'data' => (new \DateTime()), // Utilise la date d'aujourd'hui comme valeur par défaut
                'format' => 'yyyy-MM-dd',

            ])
            ->add('adulte',null, [
                'attr' => ['class' => 'form-control bg-transparent'],
            ])
            ->add('enfant',null, [
                'attr' => ['class' => 'form-control bg-transparent'],
            ]);
            
        if ($currentRoute === 'app_main') {
                $builder->add('voyage', EntityType::class, [
                    'class' => Voyage::class,
                    'choice_label' => 'titre',
                    'attr' => ['class' => 'form-control bg-transparent'],
                ]);
            }
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
