<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\OrderDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormEvents;

class OrderDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'name',
            ])
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantité',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('unit_price', MoneyType::class, [
                'currency' => 'EUR',
                'label' => 'Prix unitaire',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('total_every_unit', MoneyType::class, [
                'currency' => 'EUR',
                'label' => 'Total',
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderDetails::class,
        ]);
    }
}
