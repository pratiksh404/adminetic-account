<?php

namespace Adminetic\Account\Console\Commands;

use Illuminate\Console\Command;

class AccountRollbackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:rollback:adminetic-account  {--f|force : Force the operation to run when in production.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to rollback adminetic account module tables.';

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
        if (config('account.publish_migrations', true)) {
            $path = config('account.migration_publish_path', 'database/migrations/account');

            if (file_exists($path)) {
                $this->call('migrate:reset', [
                    '--path' => $path,
                    '--force' => $this->option('force'),
                ]);
                $this->info('Adminetic account module migration rollback complete ... ✅');
            } else {
                $this->warn('No migrations found! Consider publish them first: <fg=green>php artisan vendor:publish --tag=account-migrations</>');
            }
        } else {
            $this->info('Please turn on publish_migrations option in config/account');
        }
    }
}
