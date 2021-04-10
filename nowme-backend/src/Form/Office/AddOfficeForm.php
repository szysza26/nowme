<?php

declare(strict_types=1);

namespace NowMe\Form\Security;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class OfficeForm extends AbstractType
{
    /**
     * @param array<mixed> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Please enter a name office',
                            ]
                        )
                    ],
                ]
            )
            ->add(
                'address',
                IntegetType::class,
                [
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Please select address office',
                            ]
                        )
                    ],
                ]
            );
    }
}