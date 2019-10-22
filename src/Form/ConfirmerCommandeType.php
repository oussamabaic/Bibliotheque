<?php

namespace App\Form;

use App\Entity\ConfirmerCommande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Commande;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ConfirmerCommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Commandes',EntityType::class,[
                'class' => Commande::class,
                'choice_label' => 'title'
            ])
            ->add('title')
            ->add('user',HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ConfirmerCommande::class,
        ]);
    }
}
