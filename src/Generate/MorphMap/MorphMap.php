<?php

namespace ArtisanUp\MorphUp\Generate\MorphMap;

use ArtisanUp\MorphUp\Generate\MorphMapping\MorphMappingCollection;

class MorphMap
{
    private MorphMappingCollection $morphMappings;

    public function __construct()
    {
        $this->morphMappings = new MorphMappingCollection([]);
    }

    public function toArray(): array
    {
        return [];
    }

    public function addMorphMapping(MorphMapping $morphMapping): void
    {
        $key = $morphMapping->getMorphString();

        if ($this->morphMappings->has($key)) {
        }
        $this->morphMappings->put($morphMapping->getMorphString(), $morphMapping);
    }
}
