<?php

declare(strict_types=1);

namespace NowMe\Query\Api\Model;

final class DictionaryService implements \JsonSerializable
{
    public function __construct(private int $id, private string $name)
    {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id(),
            'name' => $this->name(),
        ];
    }
}
