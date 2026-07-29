<?php

namespace App\Form;

use App\Dto\Security\LoginUserDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginType extends AbstractType
{
    public function __construct(
        private readonly AuthenticationUtils $authenticationUtils,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
                'data' => $this->authenticationUtils->getLastUsername(),
                'attr' => [
                    'placeholder' => 'your@email.com',
                    'autocomplete' => 'email',
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'required' => true,
                'attr' => [
                    'placeholder' => '••••••••',
                ],
            ])
            ->add('login', SubmitType::class, [
                'label' => 'Login',
                'attr' => [
                    'class' => 'auth-button',
                ],
            ])
            ->add('rememberMe', CheckboxType::class, [
                'label' => 'Remember me',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data' => function (Options $options): array {
                return [
                    'email' => $this->authenticationUtils->getLastUsername(),
                ];
            },
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'login',
        ]);
    }
}
