<?php

namespace App\Form;

use App\Data\FilterData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('signification', TextType::class, [
                'required' => false,
                'row_attr' => [
                    'class' => 'col-12 col-sm-6 col-lg-12 mb-3'
                ],
                'label_attr' => [
                    'class' => 'fw-bold mb-1'
                ]
            ])
            ->add('stroke', TextType::class, [
                'label' => 'Nombre de trait',
                'required' => false,
                'row_attr' => [
                    'class' => 'col-12 col-sm-6 col-lg-12 mb-3'
                ],
                'label_attr' => [
                    'class' => 'fw-bold mb-1'
                ],
            ])
            ->add('jlpt', ChoiceType::class, [
                'label' => 'Niveau JLPT',
                'required' => false,
                'label_attr' => [
                    'class' => 'fw-bold mb-1'
                ],
                'choices'  => [
                    'Niveau 1' => 1,
                    'Niveau 2' => 2,
                    'Niveau 3' => 3,
                    'Niveau 4' => 4,
                    'Niveau 5' => 5,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FilterData::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
