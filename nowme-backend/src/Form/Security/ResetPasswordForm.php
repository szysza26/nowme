<?php

declare(strict_types=1);

namespace NowMe\Form\Security;

use NowMe\Controller\Api\Security\Model\ResetPasswordRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ResetPasswordForm extends AbstractType
{
    /**
     * @param array<mixed> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'plainPassword',
            RepeatedType::class,
            [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match',
                'constraints' => [
                    new NotBlank(
                        [
                            'message' => 'Please enter a password',
                        ]
                    ),
                    new Length(
                        [
                            'min' => 6,
                            'minMessage' => 'Your password should be at least {{ limit }} characters',
                            'max' => 4096,
                            // https://symfony.com/blog/cve-2013-5750-security-issue-in-fosuserbundle-login-form
                        ]
                    ),
                ],
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => ResetPasswordRequest::class]);
    }
}