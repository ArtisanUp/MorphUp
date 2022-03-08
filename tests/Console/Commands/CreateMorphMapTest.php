<?php

namespace ArtisanUp\Tests\MorphUp\Console\Commands;

use ArtisanUp\MorphUp\Console\Commands\CreateMorphMap;
use ArtisanUp\MorphUp\Filter\ClassFilter;
use ArtisanUp\MorphUp\Find\ClassFinder;
use ArtisanUp\MorphUp\Generate\MorphMap\MorphMapFileWriter;
use ArtisanUp\MorphUp\Generate\MorphMap\MorphMapGenerator;
use GrahamCampbell\TestBench\AbstractPackageTestCase;

class CreateMorphMapTest extends AbstractPackageTestCase
{
    public function testItInstantiates()
    {
        $classFinder = $this->mock(ClassFinder::class);
        $classFilter = $this->mock(ClassFilter::class);
        $morphMapGenerator = $this->mock(MorphMapGenerator::class);
        $morphFileWriter = $this->mock(MorphMapFileWriter::class);

        $createMorphMapCommand = new CreateMorphMap($classFinder, $classFilter, $morphFileWriter, $morphMapGenerator);

        $this->assertInstanceOf(CreateMorphMap::class, $createMorphMapCommand);
    }
}
