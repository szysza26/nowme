<?php

declare(strict_types=1);

namespace NowMe\Form\Reservation;

use NowMe\Entity\Office;
use NowMe\Entity\Service;
use NowMe\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

final class CreateReservationForm extends AbstractType
{
    /**
     * @param array<mixed> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'service',
                EntityType::class,
                [
                    'class' => Service::class,
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Please enter service',
                            ]
                        )
                    ],
                ]
            )
            ->add(
                'office',
                EntityType::class,
                [
                    'class' => Office::class,
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Please enter a office.',
                            ]
                        )
                    ],
                ]
            )
            ->add(
                'specialist',
                EntityType::class,
                [
                    'class' => User::class,
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Please enter a specialist',
                            ]
                        )
                    ],
                ]
            )
            ->add(
                'reservation_date',
                DateTimeType::class,
                [
                    'constraints' => [
                        new NotNull(),
                    ],
                    'html5' => false,
                    'widget' => 'single_text',
                    'format' => 'Y-M-d H:i',
                    'input' => 'string',
                ]
            );
    }
}