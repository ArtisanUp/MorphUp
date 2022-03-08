<?php

namespace ArtisanUp\MorphUp\Generate\MorphMapping;

use ArtisanUp\MorphUp\Find\FoundClass;
use ArtisanUp\MorphUp\Generate\MorphMap\MorphMapping;

class MorphMappingFactory
{
    private string $defaultMode = '';

    private string $safeMode = '';

    public function make(FoundClass $foundClass, bool $safeMode = false): MorphMapping
    {
        $reflection = $foundClass->getReflectionClass();

        $morphName = $reflection->hasProperty('morphString') ? $foundClass->getClassName()::$morphString : $this->namespaceToSnakeCase($reflection->getShortName());

        $morphString = null;

        $qualifiedMorphName = $this->namespaceToSnakeCase($reflection->getName());
        $morphMap[$qualifiedMorphName] = $foundClass->getClassName();

        //TODO: real implementation
        return new MorphMapping($foundClass, '');
    }

    private function namespaceToSnakeCase(string $namespace): string
    {
        $snakeCase = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $namespace));

        return str_replace('\\', '', $snakeCase);
    }

    private function generateClashSafeString(FoundClass $foundClass): string
    {
        return '';
    }

    private function generateDefaultMorphString(): string
    {
        return '';
    }
}
