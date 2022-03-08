<?php

namespace ArtisanUp\MorphUp\Generate\MorphMap;

use ArtisanUp\MorphUp\Generate\MorphMapping\MorphMappingCollection;
use Illuminate\Contracts\Support\Arrayable;

class MorphMap implements Arrayable
{
    private MorphMappingCollection $morphMappings;

    public function __construct()
    {
        $this->morphMappings = new MorphMappingCollection([]);
    }

    public function toArray()
    {
        return $this->morphMappings->pluck(
            'morphed_class',
            'morph_string'
        );
    }

    public function addMorphMapping(MorphMapping $morphMapping): void
    {
        $key = $morphMapping->getMorphString();

        if ($this->morphMappings->has($key)) {
            $this->throwClashException($key, $morphMapping);
        }

        $this->morphMappings->put($morphMapping->getMorphString(), $morphMapping);
    }

    private function throwClashException(string $key, MorphMapping $morphMapping): void
    {
        $exception = new MorphStringClashException();
        $exception->setClashingMapping($morphMapping);
        $exception->setClashedWithMapping($this->morphMappings->get($key));

        throw $exception;
    }
}
