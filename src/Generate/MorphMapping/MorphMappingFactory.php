<?php

namespace ArtisanUp\MorphUp\Generate\MorphMapping;

use ArtisanUp\MorphUp\Find\FoundClass;
use ArtisanUp\MorphUp\Generate\MorphMap\MorphMapping;

class MorphMappingFactory
{
    private MorphMappingStrategy $defaultMode = MorphMappingStrategy::CLASS_NAME_SNAKE;
    private MorphMappingStrategy $safeMode = MorphMappingStrategy::FULL_NAMESPACE_SNAKE;

    public function make(FoundClass $foundClass, bool $safeMode = false): MorphMapping
    {
        $morphName = $this->makeMorphString($foundClass, $safeMode);

        return new MorphMapping($foundClass, $morphName);
    }

    private function makeMorphString(FoundClass $foundClass, bool $safeMode = false): string
    {
        //TODO: Honour configurability of morph string type
        $reflection = $foundClass->getReflectionClass();

        if ($safeMode) {
            return $this->namespaceToSnakeCase($reflection->getShortName());
        }

        //TODO: Is it always safe to return morphString? Need an indicator of if we're dealing with a clash or not.
        return $reflection->hasProperty('morphString') ? $foundClass->getClassName()::$morphString : $this->namespaceToSnakeCase($reflection->getShortName());
    }

    private function namespaceToSnakeCase(string $namespace): string
    {
        $snakeCase = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $namespace));

        return str_replace('\\', '', $snakeCase);
    }
}
