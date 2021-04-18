<?php

declare(strict_types=1);

namespace NowMe\Query\Api\Model;

final class DictionaryServices implements \IteratorAggregate, \JsonSerializable
{
    /**
     * @var DictionaryService[]
     */
    private array $dictionaryServices;

    public function __construct(DictionaryService ...$dictionaryServices)
    {
        $this->dictionaryServices = $dictionaryServices;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->dictionaryServices);
    }

    public function jsonSerialize()
    {
        return array_map(
            static function (DictionaryService $dictionaryService) {
                return $dictionaryService;
            },
            $this->dictionaryServices
        );
    }
}
