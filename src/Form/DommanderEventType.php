<?php

namespace App\Form;

use App\Entity\DommanderEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Event;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class DommanderEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Events',EntityType::class,[
                'class' => Event::class,
                'choice_label' => 'title'
            ])
            ->add('billet')
            ->add('email',HiddenType::class)
            ->add('username',HiddenType::class)
            ->add('image',HiddenType::class)
            ->add('sexe',HiddenType::class)
            ->add('adresse',HiddenType::class)
            ->add('telephone',HiddenType::class)
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DommanderEvent::class,
        ]);
    }
}
