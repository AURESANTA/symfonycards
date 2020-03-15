<?php

namespace App\Form;

use App\Entity\Card;
use App\Entity\Faction;
use App\Entity\Passive;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cardName')
            ->add('lifePoints')
            ->add('attackPoints')
            ->add('manaCost')
            ->add('faction', EntityType::class, [
                'class' => faction::class,
                'choice_label' => function(Faction $faction) {
                    return $faction->getFactionName();
                },
            ])
            ->add('passive', EntityType::class, [
                'class' => passive::class,
                'choice_label' => function(Passive $passive) {
                    return $passive->getPassivename();
                },
            ])
            ->add('image', FileType::class)
            ->add('image', FileType::class, array('data_class' => null,'required' => false))
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
