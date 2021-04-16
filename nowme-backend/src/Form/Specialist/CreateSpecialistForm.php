<?php

declare(strict_types=1);

namespace NowMe\Form\Specialist;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;

final class CreateSpecialistForm extends AbstractType
{
    /**
     * @param array<mixed> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'username',
                TextType::class,
                [
                    'constraints' => [
                        new NotNull(),
                    ]
                ]
            )->add(
                'role',
                ChoiceType::class,
                [
                    'choices' => [
                        'Uprawnienia specjalista' => 'ROLE_SPECIALIST',
                    ],
                    'constraints' => [
                        new NotNull(),
                    ]
                ]
            );
    }
}
