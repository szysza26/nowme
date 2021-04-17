<?php

declare(strict_types=1);

namespace NowMe\Form\Specialist;

use NowMe\Entity\Office;
use NowMe\Repository\OfficeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

final class CreateSpecialistForm extends AbstractType
{
    public function __construct(private OfficeRepository $officeRepository)
    {
    }

    /**
     * @param array<mixed> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $offices = $this->officeRepository->all();

        $offices = array_map(
            static function ($office) {
                /**
                 * @var Office $office
                 */
                return [
                    $office->getName() => $office->getId()
                ];
            },
            $offices
        );

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
                'offices',
                ChoiceType::class,
                [
                    'choices' => $offices,
                    'multiple' => true,
                    'constraints' => [
                        new NotNull(),
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'allow_extra_fields' => true
            ]
        );
    }
}
