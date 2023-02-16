<?php

declare(strict_types=1);

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\GeneratorTrait;

class MakeTestCommand extends BaseCommand
{
    use GeneratorTrait;

    protected $group          = 'Generators';
    protected $name           = 'make:test';
    protected $description    = 'Generate a new test file.';
    protected $usage          = 'make:test [name] [options]';
    protected $arguments      = [
        'name' => 'The test class name.',
    ];
    protected $options        = [
        '--force' => 'Force overwrite existing file.',
    ];

    private string $testsPath = ROOTPATH . 'tests/app/';
    private string $stubPath  = ROOTPATH . 'stubs/test.stub';

    public function run(array $params): void
    {
        $name     = $params[0] ?? null;
        $isForced = $this->getOption('force') ?? false;

        if (!$name) {
            $name = CLI::prompt('Test name', validation: ['required']);
        }

        $stub = file_get_contents($this->stubPath);

        [$directories, $content] = $this->prepare($name, $stub);

        array_pop($directories);

        if (!file_exists($this->testsPath)) {
            mkdir($this->testsPath . implode('/', $directories), 0775, true);
        }

        $file = "{$this->testsPath}{$name}.php";

        if (!file_exists($file) || (file_exists($file) && $isForced)) {
            $this->create($file, $content, "tests/app/{$name}.php");

            return;
        }

        CLI::error('File is already exists.');
    }

    private function prepare(string $name, string $stub): array
    {
        $directories = explode('/', $name);
        $className   = end($directories);
        $namespace   = $this->prepareNamespace($name);
        $content     = $this->prepareContent($namespace, $className, $stub);

        return [
            $directories,
            $content,
        ];
    }

    private function prepareNamespace(string $name): string
    {
        return 'App\\' . str_replace('/', '\\', $name);
    }

    private function prepareContent(string $namespace, string $className, string $stub): string
    {
        return str_replace(['{{ $namespace }}', '{{ $className }}'], [$namespace, $className], $stub);
    }

    private function create(string $file, string $content, string $location): void
    {
        file_put_contents($file, $content);
        CLI::write('File created: ' . $location, 'green');
    }
}
