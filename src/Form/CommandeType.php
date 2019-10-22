<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Entity\Livraison;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('user',HiddenType::class)
            ->add('created_At', ChoiceType::class, [
                'choices' => [
                    'tomorrow' => new \DateTime('+1 day'),
                    '1 week' => new \DateTime('+1 week'),
                    '1 month' => new \DateTime('+1 month'),
                ],
                'group_by' => function($choice, $key, $value) {
                    if ($choice <= new \DateTime('+3 days')) {
                        return 'Soon';
                    } else {
                        return 'Later';
                    }
                },
            ])
            ->add('Livraison',EntityType::class,['class'=>Livraison::class,'choice_label'=>'title'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
