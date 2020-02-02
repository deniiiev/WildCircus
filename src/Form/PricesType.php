<?php

namespace App\Form;

use App\Entity\Prices;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PricesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('service', null, [
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Service'
                ]
            ])
            ->add('week', null, [
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Weeks in $'
                ]
            ])
            ->add('weekend', null, [
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Weekends in $'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prices::class,
        ]);
    }
}
