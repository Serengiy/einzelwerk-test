<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallAppCommand extends Command
{

    protected $signature = 'app:install';


    protected $description = 'Command description';


    public function handle()
    {
        $this->call('migrate');
        $this->call('db:seed', ['--class' => 'ContragentSeeder']);
        $this->call('db:seed', ['--class' => 'UserSeeder']);
    }
}
