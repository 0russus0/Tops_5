<?php

namespace App\Form\TopElement;

use App\Entity\TopElement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateTopElementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('response_one', TextType::class, [
                'required' => true,
                'mapped' => false,
            ])
            ->add('response_two', TextType::class, [
                'required' => true,
                'mapped' => false,
            ])
            ->add('response_three', TextType::class, [
                'required' => true,
                'mapped' => false,
            ])
            ->add('response_four', TextType::class, [
                'required' => true,
                'mapped' => false,
            ])
            ->add('response_five', TextType::class, [
                'required' => true,
                'mapped' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => ['class' => 'btn']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TopElement::class,
        ]);
    }
}
