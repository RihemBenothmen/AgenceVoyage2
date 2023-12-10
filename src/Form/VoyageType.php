<?php

namespace App\Form;

use App\Entity\Voyage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class VoyageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',null, [
                'attr' => ['class' => 'form-control bg-transparent'],
            ])
            ->add('description',TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'rows' => 5,
                    'class' => 'form-control bg-transparent',
                     // Adjust the number of rows as needed
                ],
            ])
            ->add('prix',null, [
                'attr' => ['class' => 'form-control bg-transparent'],
            ])
            ->add('image', FileType::class, ['label' => 'Image',
            'data_class' => null])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voyage::class,
        ]);
    }
}
