<?php

namespace ArtisanUp\Tests\MorphUp\Console\Commands;

use ArtisanUp\MorphUp\Console\Commands\CreateMorphMap;
use Nette\Loaders\RobotLoader;
use GrahamCampbell\TestBench\AbstractPackageTestCase;
use \Mockery;


class CreateMorphMapTest extends AbstractPackageTestCase 
{
    public function testItInstantiates()
    {
        $robotLoaderMock = $this->mock(RobotLoader::class);
        $createMorphMapCommand = new CreateMorphMap($robotLoaderMock);

        $this->assertInstanceOf(CreateMorphMap::class, $createMorphMapCommand);
    }

}