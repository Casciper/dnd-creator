<?php

namespace App\Orchid\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use function app_path;

class MakeModifiedFormRequest extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rocont:make_request {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create pattern of modified FormRequest';

    public function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Http\Requests';
    }

    public function replaceClass($stub, $name)
    {
        $name = str_contains($this->argument('name'), '/')
            ? substr($this->argument('name'), strrpos($this->argument('name'), '/') + 1)
            : $this->argument('name');

        $stub = parent::replaceClass($stub, $name);

        return str_replace("RocontFormRequest", $name, $stub);
    }

    protected function getStub()
    {
        return app_path() . '/Orchid/Console/Stubs/form-request.stub';
    }
}
