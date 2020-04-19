<?php

namespace App\Form;

use App\Entity\OrderDetail;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Form to creates order details.
 * @package App\Form
 */
class OrderDetailType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price', HiddenType::class)
            ->add('quantity', HiddenType::class)
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'attr' => [
                    'style' => 'display:none;'
                ]
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderDetail::class,
        ]);
    }
}
