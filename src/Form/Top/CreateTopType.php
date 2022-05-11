<?php

namespace App\Form\Top;

use App\Entity\Category;
use App\Entity\Top;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateTopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('POST')
            ->add('title', TextType::class, [
                'required' => true,
            ])
            ->add('category', EntityType::class, [
                'required' => true,
                'class' => Category::class,
                'choice_label' => 'title'
            ])
            ->add('icon', TextType::class, [
                'required' => true,
            ])
            ->add('color', EnumType::class, [
                'required' => true,
            ])
            ->add('collaborative', CheckboxType::class, [
                'required' => true,
            ])
            ->add('deadline', DateTimeType::class, [
                'required' => true,
                'format' => DateTimeType::HTML5_FORMAT,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Top::class,
        ]);
    }
}
