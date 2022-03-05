<?php

namespace ArtisanUp\MorphUp\Console\Commands;

use ArtisanUp\MorphUp\Filter\ClassFilter;
use ArtisanUp\MorphUp\Find\ClassFinder;
use ArtisanUp\MorphUp\Find\FoundClass;
use Illuminate\Console\Command;

class CreateMorphMap extends Command
{
    protected $description = 'Create an automated cached morphmap file.';

    protected $signature = 'morph-up:create-morph-map';

    public function __construct(private ClassFinder $classFinder, private ClassFilter $classFilter)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->info('Generating morph map...');

        $morphMap = [];

        $foundClasses = $this->classFinder->findClasses(
            includedPaths: config('morphmap.paths_to_scan'),
            excludedPaths: config('morphmap.paths_to_exclude')
        );

        $filteredClasses = $this->classFilter->filterFoundClasses(
            foundClasses: $foundClasses,
            excludePathsContaining: config('morphmap.exclude_paths_containing'),
            excludeNamespacesContaining: config('morphmap.exclude_namespaces_containing')
        );

        $filteredClasses->each(function (FoundClass $foundClass) use (&$morphMap): void {
            $reflection = $foundClass->getReflectionClass();

            $morphName = $reflection->hasProperty('morphString') ? $foundClass->getClassName()::$morphString : $this->namespaceToSnakeCase($reflection->getShortName());

            if (!isset($morphMap[$morphName])) {
                $morphMap[$morphName] = $foundClass->getClassName();
                return;
            }

            $qualifiedMorphName = $this->namespaceToSnakeCase($reflection->getName());
            $morphMap[$qualifiedMorphName] = $foundClass->getClassName();

            $this->warn("!! Morph string '$morphName' for model '{$foundClass->getClassName()}' clashes with morph for '{$morphMap[$morphName]}'. Namespace based string '{$qualifiedMorphName}' used instead. You should correct this using static property \$morphString on the model.");
        });

        $this->writeCacheFile($morphMap);

        $this->info('Morph map generated.');
    }

    private function namespaceToSnakeCase(string $namespace): string
    {
        $snakeCase = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $namespace));
        return str_replace('\\', '', $snakeCase);
    }

    private function writeCacheFile(array $morphMap): void
    {
        $directory = storage_path('app/artisan-up/morph-up'); //TOOD: Make cofigurable
        $fileName = 'morph-cache.php';
        $filePath = $directory . DIRECTORY_SEPARATOR . $fileName;

        if (!is_dir($directory)) {
            mkdir($directory);
        }

        file_put_contents(
            $filePath,
            '<?php return ' . var_export($morphMap, true) . ';'
        );
    }
}