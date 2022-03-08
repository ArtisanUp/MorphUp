<?php

namespace ArtisanUp\MorphUp\Generate\MorphMap;

use ArtisanUp\MorphUp\Generate\MorphMapping\MorphMappingFactory;

class MorphMapGenerator
{
 
    public function __construct(private MorphMappingFactory $morphMappingFactory)
    {
        
    }
    public function generateMorphMap(): MorphMap
    {
        $morphMap = new MorphMap();

        return $morphMap;
    }
    
    private function handleMorphClash()
    {
        

    }
}