<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProductForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'form.name',
                'attr' => [
                    'placeholder' => 'form.name_placeholder',
                ],
            ])
            ->add('description',  TextareaType::class, [
                'label' => 'form.description',
                'attr' => [
                    'placeholder' => 'form.description_placeholder',
                ],
            ])
            ->add('price', IntegerType::class, [
                'label' => 'form.price',
                'attr' => [
                    'placeholder' => 'form.price_placeholder',
                ],
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'form.category',
                'choices' => [
                    'form.casual' => 'casual',
                    'form.sporty' => 'sporty',
                    'form.boho' => 'boho',
                    'form.streetwear' => 'streetwear',
                    'form.formal' => 'formal',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
