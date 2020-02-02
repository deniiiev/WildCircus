<?php

namespace App\Form;

use App\Entity\Performances;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PerformancesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Title'
                ]
            ])
            ->add('description', null, [
                'attr' => [
                    'class' => 'uk-textarea ckeditor',
                    'placeholder' => 'Description',
                    'rows' => '5'
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Performances::class,
        ]);
    }
}
