<?php

namespace App\Form;

use App\Entity\Cigarette;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Tests\Extension\Core\Type\NumberTypeTest;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CigaretteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price', ChoiceType::class, [
                'label' => 'Tu fumes quoi ?',
                'choices' => [
                    'Allez, une petite roulée' => 0.30,
                    'Une bonne indus tiens !' => 0.50
                ]
            ])
            ->add('isSmoked', ChoiceType::class, [
                'label' => 'Et t\'en fais quoi ? ',
                'choices' => [
                    'Tu vas la fumer pour de vrai ' => true,
                    'Tu ne fais que la démarche psychologique' => false
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cigarette::class,
        ]);
    }
}
