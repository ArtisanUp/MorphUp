<?php

namespace ArtisanUp\MorphUp\Generate\MorphMap;

use ArtisanUp\MorphUp\Find\FoundClass;
use ArtisanUp\MorphUp\Find\FoundClassCollection;
use ArtisanUp\MorphUp\Generate\MorphMapping\MorphMappingFactory;

class MorphMapGenerator
{
    public function __construct(private MorphMappingFactory $morphMappingFactory)
    {
    }

    public function generateMorphMap(FoundClassCollection $foundClassCollection): MorphMap
    {
        $morphMap = new MorphMap();

        $foundClassCollection->each(
            function (FoundClass $foundClass) use (&$morphMap) {
                try {
                    $morphMapping = $this->morphMappingFactory->make($foundClass);
                    $morphMap->addMorphMapping($morphMapping);
                } catch (MorphStringClashException $exception) {
                    $morphMapping = $this->morphMappingFactory->make($foundClass, true);
                    $morphMapping->addException($exception);
                    $morphMap->addMorphMapping($morphMapping);
                }
            }
        );

        return $morphMap;
    }
}
