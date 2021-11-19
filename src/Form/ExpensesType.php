<?php

namespace App\Form;

use App\Entity\Depense;
use App\Entity\Participant;
use App\Entity\Tricount;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpensesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('created_at')
            ->add('amount_total')
            ->add('pay_master', EntityType::class, [
                "class" => Participant::class,
                "choice_label" => 'id',
                "expanded" => true,
                "multiple" => true,
            ])
            ->add('tricount', EntityType::class, [
                "class" => Tricount::class,
                "choice_label" => "title",
                "expanded" => true,
                "multiple" => true,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Depense::class,
        ]);
    }
}
