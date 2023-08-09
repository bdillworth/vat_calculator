<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MonetaryValueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('originalAmount', NumberType::class, [
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Enter Monetary Amount',
                    'id' => '',
                    'required',
                ),
                'html5' => true
            ])
            ->add('vatRate', NumberType::class, [
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Enter VAT Rate',
                    'id' => '',
                    'required'
                ),
                'html5' => true
            ])
            ->add('vatStatus', ChoiceType::class, [
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => '',
                    'id' => ''
                ),
                'choices' => [
                    'Including VAT' => 'including',
                    'Excluding VAT' => 'excluding',
                ]
            ])
            ->add('save', SubmitType::class, [
                'attr' => array(
                    'class' => 'btn btn-primary',
                    'placeholder' => '',
                    'id' => ''
                )
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
