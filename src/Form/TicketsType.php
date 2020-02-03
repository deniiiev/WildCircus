<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('days', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'Week' => false,
                    'Weekend' => true
                ],
                'attr' => [
                    'class' => 'uk-select'
                ]
            ])
        ;
        foreach ($options['prices'] as $value) {

            $builder
                ->add(str_replace(' ','',strtolower($value->getService())), IntegerType::class, [
                    'label' => $value->getService(),
                    'mapped' => false,
                    'required' => false,
                    'attr' => [
                        'min' => 0,
                        'class' => 'uk-input',
                        'placeholder' => 'Quantity'
                    ]
                ])
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
            'prices' => null,
        ]);
    }
}
