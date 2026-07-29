<?php

namespace App\Form;

use App\Dto\Security\TwoFactorCodeDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TwoFactorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'Authentication code',
                'required' => true,
                'attr' => [
                    'class' => 'auth-code-input',
                    'placeholder' => '123456',
                    'autocomplete' => 'one-time-code',
                    'maxlength' => '6',
                ],
            ])
            ->add('verify', SubmitType::class, [
                'label' => 'Verify code',
                'attr' => [
                    'class' => 'auth-button',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
