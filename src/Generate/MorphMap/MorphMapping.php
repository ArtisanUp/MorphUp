<?php

namespace ArtisanUp\MorphUp\Generate\MorphMap;

use ArtisanUp\MorphUp\Find\FoundClass;

class MorphMapping 
{
    public function __construct(
        private FoundClass $foundClass,
        private string $morphString, 
        private array $exceptions = []
        )
    {     
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
}