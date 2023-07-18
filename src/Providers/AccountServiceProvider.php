<?php

namespace Adminetic\Account\Providers;

use Livewire\Livewire;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Adminetic\Account\Services\Account;
use Illuminate\Support\ServiceProvider;
use Adminetic\Account\Models\Admin\Entry;
use Adminetic\Account\Models\Admin\Fiscal;
use Adminetic\Account\Models\Admin\Ledger;
use Adminetic\Account\Models\Admin\Journal;
use Adminetic\Account\Policies\EntryPolicy;
use Adminetic\Account\Models\Admin\Transfer;
use Adminetic\Account\Policies\FiscalPolicy;
use Adminetic\Account\Policies\LedgerPolicy;
use Adminetic\Account\Policies\AccountPolicy;
use Adminetic\Account\Policies\JournalPolicy;
use Adminetic\Account\Policies\TransferPolicy;
use Adminetic\Account\Models\Admin\Transaction;
use Adminetic\Account\Policies\TransactionPolicy;
use Adminetic\Account\Console\Commands\AccountInstallCommand;
use Adminetic\Account\Console\Commands\AccountMigrateCommand;
use Adminetic\Account\Console\Commands\AccountRollbackCommand;
use Adminetic\Account\Http\Livewire\Admin\Entry\EntryApproval;
use Adminetic\Account\Http\Livewire\Admin\Journal\JournalPanel;
use Adminetic\Account\Http\Livewire\Admin\Ledger\LedgerProfile;
use Adminetic\Account\Http\Livewire\Admin\Report\LedgerSummary;
use Adminetic\Account\Console\Commands\AccountPermissionCommand;
use Adminetic\Account\Http\Livewire\Admin\Report\ChartOfAccount;
use Adminetic\Account\Http\Livewire\Admin\Entities\LedgerAccount;
use Adminetic\Account\Http\Livewire\Admin\Transfer\TransferPanel;
use Adminetic\Account\Http\Livewire\Admin\Report\UserAccountAudit;
use Adminetic\Account\Http\Livewire\Admin\Report\TransactionReport;
use Adminetic\Account\Http\Livewire\Admin\Transaction\TransactionPanel;
use Adminetic\Account\Http\Livewire\Admin\Entities\IncomeExpenseSubjects;
use Adminetic\Account\Http\Livewire\Admin\Journal\PolymorphicJournalPanel;
use Adminetic\Account\Http\Livewire\Admin\Entry\EntryTransformToTransaction;
use Adminetic\Account\Http\Livewire\Admin\Journal\JournalApproval;
use Adminetic\Account\Http\Livewire\Admin\Journal\PolymorphicSpecificLedgerAccountJournalEntry;
use Adminetic\Account\Http\Livewire\Admin\Report\CumulativeBalanceReport;
use Adminetic\Account\Http\Livewire\Admin\Report\ProfitLossReport;
use Adminetic\Account\Http\Livewire\Admin\Transaction\TransactionApproval;

class AccountServiceProvider extends ServiceProvider
{
    // Register Policies
    protected $policies = [
        Account::class => AccountPolicy::class,
        Entry::class => EntryPolicy::class,
        Fiscal::class => FiscalPolicy::class,
        Journal::class => JournalPolicy::class,
        Ledger::class => LedgerPolicy::class,
        Transaction::class => TransactionPolicy::class,
        Transfer::class => TransferPolicy::class,
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish Ressource
        if ($this->app->runningInConsole()) {
            $this->publishResource();
        }
        // Register Resources
        $this->registerResource();
        // Register Policies
        $this->registerPolicies();
        // Register View Components
        $this->registerLivewireComponents();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /* Repository Interface Binding */
        $this->repos();
        /* Register Commands */
        $this->registerCommands();
        /* Register Facades */
        $this->registerFacades();
    }

    /**
     * Publish Package Resource.
     *
     *@return void
     */
    protected function publishResource()
    {
        // Publish Config File
        $this->publishes([
            __DIR__ . '/../../config/account.php' => config_path('account.php'),
        ], 'account-config');
        // Publish Migration Files
        $this->publishes([
            __DIR__ . '/../../database/migrations' => database_path('migrations/account'),
        ], 'account-migrations');
    }

    /**
     * Register Package Resource.
     *
     *@return void
     */
    protected function registerResource()
    {
        if (!config('account.publish_migrations', true)) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations'); // Loading Migration Files
        }
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'account'); // Loading Views Files
        $this->registerRoutes();
    }

    /**
     * Register Facades.
     *
     *@return void
     */
    protected function registerFacades()
    {
        $this->app->bind('account', \Adminetic\Account\Services\Account::class);
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Account', "Adminetic\\Account\\Facades\\Account");
    }


    /**
     * Register Routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        });
    }

    /**
     * Register Route Configuration.
     *
     * @return array
     */
    protected function routeConfiguration()
    {
        return [
            'prefix' => config('adminetic.prefix', 'admin'),
            'middleware' => config('adminetic.middleware', ['web', 'auth']),
        ];
    }


    /**
     * Register Components.
     *
     *@return void
     */
    protected function registerLivewireComponents()
    {
        /* Entities */
        Livewire::component('admin.entities.income-expense-subjects', IncomeExpenseSubjects::class);
        Livewire::component('admin.entities.ledger-account', LedgerAccount::class);
        /* Journal */
        Livewire::component('admin.journal.journal-panel', JournalPanel::class);
        /* Ledger */
        Livewire::component('admin.ledger.ledger-profile', LedgerProfile::class);
        /* Transaction */
        Livewire::component('admin.transaction.transaction-panel', TransactionPanel::class);
        Livewire::component('admin.transaction.transaction-approval', TransactionApproval::class);
        /* Transfer */
        Livewire::component('admin.transfer-transfer-panel', TransferPanel::class);
        /* Journal */
        Livewire::component('admin.journal.polymorphic-journal-panel', PolymorphicJournalPanel::class);
        Livewire::component('admin.journal.polymorphic-specific-ledger-account-journal-entry', PolymorphicSpecificLedgerAccountJournalEntry::class);
        Livewire::component('admin.journal.journal-approval', JournalApproval::class);
        /* Entry */
        Livewire::component('admin.entry.entry-transform-to-transaction', EntryTransformToTransaction::class);
        Livewire::component('admin.entry.entry-approval', EntryApproval::class);
        /* Report */
        Livewire::component('admin.report.chart-of-account', ChartOfAccount::class);
        Livewire::component('admin.report.ledger-summary', LedgerSummary::class);
        Livewire::component('admin.report.transaction-report', TransactionReport::class);
        Livewire::component('admin.report.user-account-audit', UserAccountAudit::class);
        Livewire::component('admin.report.profit-loss-report', ProfitLossReport::class);
        Livewire::component('admin.report.cumulative-balance-report', CumulativeBalanceReport::class);
    }

    /**
     * Repository Binding.
     *
     * @return void
     */
    protected function repos()
    {
        $this->app->bind(\Adminetic\Account\Contracts\AccountRepositoryInterface::class, \Adminetic\Account\Repositories\AccountRepository::class);
        $this->app->bind(\Adminetic\Account\Contracts\EntryRepositoryInterface::class, \Adminetic\Account\Repositories\EntryRepository::class);
        $this->app->bind(\Adminetic\Account\Contracts\FiscalRepositoryInterface::class, \Adminetic\Account\Repositories\FiscalRepository::class);
        $this->app->bind(\Adminetic\Account\Contracts\JournalRepositoryInterface::class, \Adminetic\Account\Repositories\JournalRepository::class);
        $this->app->bind(\Adminetic\Account\Contracts\LedgerRepositoryInterface::class, \Adminetic\Account\Repositories\LedgerRepository::class);
        $this->app->bind(\Adminetic\Account\Contracts\TransactionRepositoryInterface::class, \Adminetic\Account\Repositories\TransactionRepository::class);
        $this->app->bind(\Adminetic\Account\Contracts\TransferRepositoryInterface::class, \Adminetic\Account\Repositories\TransferRepository::class);
    }

    /**
     * Register Policies.
     *
     *@return void
     */
    protected function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     *
     * Register Commands
     *
     */
    protected function registerCommands()
    {
        $this->commands([
            AccountInstallCommand::class,
            AccountMigrateCommand::class,
            AccountPermissionCommand::class,
            AccountRollbackCommand::class,
        ]);
    }
}
