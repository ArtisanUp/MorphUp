<?php

namespace ArtisanUp\MorphUp\Generate\MorphMap;

use ArtisanUp\MorphUp\Find\FoundClass;
use Illuminate\Contracts\Support\Arrayable;

class MorphMapping implements Arrayable
{
    public function __construct(
        private FoundClass $foundClass,
        private string $morphString,
        private array $exceptions = []
    ) {
    }

    public function addException(\Exception $exception)
    {
        $this->exceptions[] = $exception;
    }

    public function getFoundClass(): FoundClass
    {
        return $this->foundClass;
    }

    public function getExceptions(): array
    {
        return $this->exceptions;
    }

    public function getMorphString(): string
    {
        return $this->morphString;
    }

    public function getMorphedClassName(): string
    {
        return $this->foundClass->getClassName();
    }

    public function toArray()
    {
        return [
            'morph_string' => $this->getMorphString(),
            'morphed_class' => $this->getMorphedClassName()
        ];
    }
}
