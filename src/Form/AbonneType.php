<?php

// src/Form/AbonneType.php
// src/Form/AbonneType.php
namespace App\Form;

use App\Entity\Abonne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AbonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('password')
            ->add('nom')
            ->add('prenom')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'multiple' => true, // Permet de sélectionner plusieurs rôles
                'expanded' => true, // Affiche les rôles sous forme de cases à cocher
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Abonne',
            'csrf_protection' => true, // Activation de la protection CSRF,
            'csrf_field_name' => '_token', // Nom du champ CSRF
            'csrf_token_id'   => 'abonne_form', // Identifiant unique pour le jeton CSRF
        ]);
    }
}