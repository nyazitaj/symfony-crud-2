<?php

namespace App\Form;

use App\Entity\Films;
use App\Entity\Seance;
use App\Entity\Salle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SeanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date début'
            ])
            ->add('lang', TextType::class, ['label' => 'Langue'])
            ->add('duree', TextType::class, ['label' => 'Durée'])
            ->add('status', TextType::class, ['label' => 'Statut'])
            ->add('film',
            EntityType::class,
            [
                'class' => Films::class,
                'choice_label' => 'title'
            ])
            ->add('salle',
            EntityType::class,
            [
                'class' => Salle::class,
                'choice_label' => 'num_salle',
                'label' => 'Salle'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Seance::class,
        ]);
    }
}
