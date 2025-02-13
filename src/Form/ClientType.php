<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Validator\Constraints as Assert;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                // 'constraints' => [
                //     new Assert\NotBlank(['message' => 'Le prénom est obligatoire.']),
                //     new Assert\Regex([
                //         'pattern' => "/^[a-zA-ZÀ-ÿ -]+$/",
                //         'message' => 'Le prénom ne peut contenir que des lettres et des espaces.'
                //     ])
                // ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                // 'constraints' => [
                //     new Assert\NotBlank(['message' => 'Le nom est obligatoire.']),
                //     new Assert\Regex([
                //         'pattern' => "/^[a-zA-ZÀ-ÿ -]+$/",
                //         'message' => 'Le nom ne peut contenir que des lettres et des espaces.'
                //     ])
                // ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                // 'constraints' => [
                //     new Assert\NotBlank(['message' => "L'email est obligatoire."]),
                //     new Assert\Email(['message' => "L'email {{ value }} n'est pas valide."])
                // ]
            ])
            ->add('phoneNumber', TelType::class, [
                'label' => 'Téléphone',
                // 'constraints' => [
                //     new Assert\NotBlank(['message' => 'Le numéro de téléphone est obligatoire.']),
                //     new Assert\Regex([
                //         'pattern' => "/^[0-9]{10}$/",
                //         'message' => 'Le numéro de téléphone doit contenir exactement 10 chiffres.'
                //     ])
                // ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                // 'constraints' => [
                //     new Assert\NotBlank(['message' => "L'adresse est obligatoire."])
                // ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
