<?php

declare(strict_types=1);

namespace NowMe\Form\Security;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class AddAddressForm extends AbstractType
{
    /**
     * @param array<mixed> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'street',
                TextType::class,
                [
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Please enter a street',
                            ]
                        )
                    ],
                ]
            )
            ->add(
                'homeNumber',
                TextType::class,
                [
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Please enter a home number',
                            ]
                        )
                    ],
                ]
            )
            ->add(
                'city',
                TextType::class,
                [
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Please enter a city',
                            ]
                        )
                    ],
                ]
            )
            ->add(
                'zip',
                TextType::class,
                [
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Please enter a zip code',
                            ]
                        )
                    ],
                ]
            );
    }
}