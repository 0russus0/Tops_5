<?php

namespace App\Form\Top;

use App\Entity\Category;
use App\Entity\Top;
use App\Enums\TopColors;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                'attr'=>['class'=>'form-control'],
                'label' => 'Le titre du TOP 5',
            ])
            ->add('category', EntityType::class, [
                'required' => true,
                'class' => Category::class,
                'attr'=>['class'=>'form-input'],
                'choice_label' => 'title'
            ])
            ->add('icon', TextType::class, [
                'required' => false,
                'attr'=>['class'=>'form-input'],
                'label' => 'L\'icône du TOP 5'
            ])
            ->add('color', EnumType::class, [
                'required' => false,
                'attr'=>['class'=>'form-input'],
                'class' => TopColors::class,
                'label' => 'La couleur du TOP 5'
            ])
            ->add('collaborative', CheckboxType::class, [
                'required' => true,
                'label' => 'Les autres Topers, peuvent-il participer à ce TOP 5 ?'
            ])
            ->add('deadline', DateTimeType::class, [
                'required' => true,
                'attr'=>['class'=>'form-input'],
                'format' => DateTimeType::HTML5_FORMAT,
                'label' => 'Jusqu\'à quand, peuvent-il participer à ce TOP 5 ?'
            ])
            ->add('submit', SubmitType::class, [
                'attr'=>['class'=>'btn']
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
