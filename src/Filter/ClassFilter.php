<?php

namespace ArtisanUp\MorphUp\Filter;

use ArtisanUp\MorphUp\Find\FoundClass;
use ArtisanUp\MorphUp\Find\FoundClassCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ClassFilter
{
    /**
     * @return Collection|FoundClass[]
     */
    public function filterFoundClasses(
        Collection $foundClasses,
        array $excludePathsContaining,
        array $excludeNamespacesContaining
    ): FoundClassCollection {
        return $foundClasses->filter(
            fn (FoundClass $foundClass) => $this->shouldMorphStringClass($foundClass, $excludePathsContaining, $excludeNamespacesContaining)
        );
    }

    private function shouldMorphStringClass(FoundClass $foundClass, array $excludePathsContaining, array $excludeNamespacesContaining): bool
    {
        $filePath = $foundClass->getFilePath();

        if (Str::contains($filePath, $excludePathsContaining)) {
            return false;
        }

        $className = $foundClass->getClassName();

        if (Str::contains($className, $excludeNamespacesContaining)) {
            return false;
        }

        if (!class_exists($className)) {
            return false;
        }

        $reflection = $foundClass->getReflectionClass();

        if ($reflection->isAbstract()) {
            return false;
        }

        if (!$reflection->isSubclassOf(Model::class)) {
            return false;
        }

        return true;
    }
}
