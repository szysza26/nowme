<?php

declare(strict_types=1);

namespace NowMe\Query\Api\Model;

final class DictionarySpecialists implements \IteratorAggregate, \JsonSerializable
{
    /**
     * @var DictionarySpecialist[]
     */
    private array $dictionarySpecialist;

    public function __construct(DictionarySpecialist ...$dictionarySpecialist)
    {
        $this->dictionarySpecialist = $dictionarySpecialist;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->dictionarySpecialist);
    }

    public function jsonSerialize()
    {
        return array_map(
            static function (DictionarySpecialist $dictionaryService) {
                return $dictionaryService;
            },
            $this->dictionarySpecialist
        );
    }
}
