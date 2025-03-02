<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\Contractor\ContractorService;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\App;

class TCommand extends Command
{
    protected $signature = 't-command';

    /**
     * The console command description.
     *
     * @throws ConnectionException
     *
     */

    public function handle()
    {
        $user = User::query()->with('contragent')->find(4);
        dd($user);


        /** @var ContractorService $service */
        $service = App::make(ContractorService::class);

        $res = $service->getContractorInformationByInn('370702075306');

        dd($res);
    }
}
