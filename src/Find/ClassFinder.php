<?php

namespace ArtisanUp\MorphUp\Find;

use Nette\Loaders\RobotLoader;
use Illuminate\Support\Collection;

class ClassFinder
{
    public function __construct(private RobotLoader $classLoader)
    {
    }

    /**
     * @return Collection|FoundClass[]
     */
    public function findClasses(array $includedPaths, array $excludedPaths): FoundClassCollection
    {
        $classesFound =  $this->getClasses(
             includedPaths: $includedPaths,
             excludedPaths: $excludedPaths
            );

        $qualifiedClassNames = new FoundClassCollection($classesFound);

        return $qualifiedClassNames->transform(
            fn(string $filePath, string $className) => new FoundClass(qualifiedClassName: $className, filePath: $filePath)
        );
    }

    private function getClasses(array $includedPaths, array $excludedPaths): array
    {
        $this->classLoader->setTempDirectory(sys_get_temp_dir()); //TODO: make configurable
        $this->classLoader->addDirectory($includedPaths);
        $this->classLoader->excludeDirectory($excludedPaths);
        $this->classLoader->refresh();

        return $this->classLoader->getIndexedClasses();
    }
}