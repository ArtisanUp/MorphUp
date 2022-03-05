<?php

namespace ArtisanUp\MorphUp\Filter;

use ArtisanUp\MorphUp\Find\FoundClass;
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
        array $excludeNamespacesContaining): Collection
    {
        return $foundClasses->filter(
            fn(FoundClass $foundClass) => $this->shouldMorphStringClass($foundClass, $excludePathsContaining, $excludeNamespacesContaining)
        );
    }

    private function shouldMorphStringClass(FoundClass $foundClass, array $excludePathsContaining, array $excludeNamespacesContaining): bool
    {
        $filePath = $foundClass->getFilePath();

        if (Str::contains($filePath, config('morphmap.exclude_paths_containing'))) {
            return false;
        }

        $className = $foundClass->getClassName();

        if (Str::contains($className, config('morphmap.exclude_namespaces_containing'))) {
            return false;
        }

        if (!class_exists($className)) {
            return false;
        }

        $reflection = $foundClass->getReflectionClass();

        if ($reflection->isAbstract()) {
            return false;
        }

        if(!$reflection->isSubclassOf(Model::class)){
            return false;
        }

        return true;
    }
}