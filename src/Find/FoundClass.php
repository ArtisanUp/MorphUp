<?php

namespace ArtisanUp\MorphUp\Find;

use ReflectionClass;

class FoundClass
{
    private ?ReflectionClass $reflectionClass = null;

    public function __construct(private string $qualifiedClassName, private string $filePath)
    {
    }

    public function getReflectionClass(): ReflectionClass
    {
        if ($this->reflectionClass === null) {
            $this->reflectionClass = new ReflectionClass($this->getClassName());
        }

        return $this->reflectionClass;
    }

    public function getClassName(): string
    {
        return $this->qualifiedClassName;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }
}
