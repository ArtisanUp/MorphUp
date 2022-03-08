<?php

namespace ArtisanUp\Tests\MorphUp\Console\Commands;

use ArtisanUp\MorphUp\Console\Commands\CreateMorphMap;
use ArtisanUp\MorphUp\Filter\ClassFilter;
use ArtisanUp\MorphUp\Find\ClassFinder;
use GrahamCampbell\TestBench\AbstractPackageTestCase;


class CreateMorphMapTest extends AbstractPackageTestCase 
{
    public function testItInstantiates()
    {
        $classFinder = $this->mock(ClassFinder::class);
        $classFilter = $this->mock(ClassFilter::class);

        $createMorphMapCommand = new CreateMorphMap($classFinder, $classFilter);

        $this->assertInstanceOf(CreateMorphMap::class, $createMorphMapCommand);
    }

}