<?php

declare(strict_types=1);

namespace NowMe\Form\Search;

use NowMe\Entity\ServiceDictionary;
use NowMe\Query\Api\Repository\ServiceDictionaryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;

final class SearchDetailsForm extends AbstractType
{
    public function __construct(private ServiceDictionaryRepository $serviceDictionaryRepository)
    {
    }

    /**
     * @param array<mixed> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $services = $this->serviceDictionaryRepository->all();

        $services = array_map(
            static function ($service) {
                /**
                 * @var ServiceDictionary $service
                 */
                return [
                    $service->name() => $service->id()
                ];
            },
            iterator_to_array($services)
        );

        $builder
            ->add(
                'office',
                TextType::class,
                [
                    'constraints' => [
                        new NotNull(),
                    ]
                ]
            )
            ->add(
                'specialist',
                TextType::class,
                [
                    'constraints' => [
                        new NotNull(),
                    ]
                ]
            )->add(
                'dateFrom',
                DateType::class,
                [
                    'constraints' => [
                        new NotNull(),
                    ],
                    'html5' => false,
                    'widget' => 'single_text',
                    'format' => 'Y-M-d',
                    'input' => 'string',
                ]
            )->add(
                'dateTo',
                DateType::class,
                [
                    'constraints' => [
                        new NotNull(),
                    ],
                    'html5' => false,
                    'widget' => 'single_text',
                    'input' => 'string',
                    'format' => 'Y-M-d',
                ]
            )->add(
                'service',
                ChoiceType::class,
                [
                    'choices' => $services,
                    'constraints' => [
                        new NotNull(),
                    ]
                ]
            );
    }
}
