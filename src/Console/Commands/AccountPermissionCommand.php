<?php

namespace Adminetic\Account\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;


class AccountPermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminetic:account-permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to seed account modules permission';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('make:permission Account --all --onlyFlags');
        $this->info('Account Module Permission Seeded ... ✅');
        Artisan::call('make:permission Entry --all --onlyFlags');
        $this->info('Entry Module Permission Seeded ... ✅');
        Artisan::call('make:permission Fiscal --all --onlyFlags');
        $this->info('Fiscal Module Permission Seeded ... ✅');
        Artisan::call('make:permission Journal --all --onlyFlags');
        $this->info('Journal Module Permission Seeded ... ✅');
        Artisan::call('make:permission Ledger --all --onlyFlags');
        $this->info('Ledger Module Permission Seeded ... ✅');
        Artisan::call('make:permission Transaction --all --onlyFlags');
        $this->info('Transaction Module Permission Seeded ... ✅');
        Artisan::call('make:permission Transfer --all --onlyFlags');
        $this->info('Transfer Module Permission Seeded ... ✅');
    }
}
