<?php

namespace App\Orchid\Console\Commands;

use App\Helpers\LoggerHelper;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeDoubleScreenCommand extends Command
{
    protected $signature = 'rocont:make_double {name}';
    protected $description = 'Create List and Edit screen';

    public function handle()
    {
        $name = $this->argument('name');
        $listScreen = $name . 'List';
        $editScreen = $name . 'Edit';

        try {
            Artisan::call('rocont:make_list', ['name' => $listScreen]);
            Artisan::call('rocont:make_edit', ['name' => $editScreen]);
        } catch (Exception $e) {
            LoggerHelper::commonErrorVerbose($e);
            $this->error('Error occurred!');
        }
        $this->info('The command executed successfully!');
    }
}
