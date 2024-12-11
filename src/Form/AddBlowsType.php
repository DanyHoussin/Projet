<?php

namespace App\Form;

use App\Entity\Blows;
use App\Entity\Character;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddBlowsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $character = $options['character'];

        $builder
            ->add('movelist')
            ->add('name')
            ->add('chosenCharacter', EntityType::class, [
                'data' => $character, // Pré-remplir avec l'ID
                'class' => Character::class,
                'choice_label' => 'name',
                'disabled' => true, // Empêche la modification
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Blows::class,
            'character' => null, // Ajoutez l'option `character` par défaut
        ]);
    }
}
