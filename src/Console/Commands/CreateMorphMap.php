<?php

namespace ArtisanUp\MorphUp\Console\Commands;

use ArtisanUp\MorphUp\Filter\ClassFilter;
use ArtisanUp\MorphUp\Find\ClassFinder;
use ArtisanUp\MorphUp\Generate\MorphMap\MorphMapFileWriter;
use ArtisanUp\MorphUp\Generate\MorphMap\MorphMapGenerator;
use Illuminate\Console\Command;

class CreateMorphMap extends Command
{
    protected $description = 'Create an automated cached morphmap file.';

    protected $signature = 'morph-up:create-morph-map';

    public function __construct(private ClassFinder $classFinder, private ClassFilter $classFilter, private MorphMapFileWriter $morphMapFileWriter, private MorphMapGenerator $morphMapGenerator)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->info('Generating morph map...');

        $foundClasses = $this->classFinder->findClasses(
            includedPaths: config('morphmap.paths_to_scan'),
            excludedPaths: config('morphmap.paths_to_exclude')
        );

        $filteredClasses = $this->classFilter->filterFoundClasses(
            foundClasses: $foundClasses,
            excludePathsContaining: config('morphmap.exclude_paths_containing'),
            excludeNamespacesContaining: config('morphmap.exclude_namespaces_containing')
        );

        $morphMap = $this->morphMapGenerator->generateMorphMap($filteredClasses);

        //TODO: Issue warnings or rethrow (setting dependant) based on any exceptions recorded inside $morphMap;

        $this->morphMapFileWriter->writeFile($morphMap);

        $this->info('Morph map generated.');
    }
}
