<?php

declare(strict_types=1);

namespace NowMe\Form\Specialist;

use NowMe\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;

final class DeleteSpecialistForm extends AbstractType
{
    /**
     * @param array<mixed> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'id',
                EntityType::class,
                [
                    'class' => User::class,
                    'constraints' => [
                        new NotNull(),
                    ]
                ]
            );
    }
}
