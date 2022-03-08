<?php

namespace ArtisanUp\MorphUp\Generate\MorphMap;

use RuntimeException;

class MorphStringClashException extends RuntimeException 
{
    private ?MorphMapping $clashingMapping = null;

    private ?MorphMapping $clashedWithMapping= null;

    public function setClashingMapping(MorphMapping $morphMapping): void
    {
        $this->clashingMapping = $morphMapping;
    }

    public function setClashedWithMapping(MorphMapping $morphMapping): void
    {
        $this->clashedWithMapping = $morphMapping;
    }

    public function getClashingMapping(): ?MorphMapping
    {
        return $this->clashingMapping;
    }

    public function getClashedWithMapping(): ?MorphMapping
    {
        return $this->clashedWithMapping;
    }


}