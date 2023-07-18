<?php

namespace Adminetic\Account\Console\Commands;

use Adminetic\Account\Models\Admin\Fiscal;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AccountInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:adminetic-account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to install adminetic account module.';

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
        if ($this->confirm('Do you wish to seed module permission?')) {
            Artisan::call('adminetic:account-permission');
            $this->info('Adminetic account permission seeded ... ✅');
        }
        if ($this->confirm('Do you wish to publish migration file?')) {
            Artisan::call('vendor:publish', ['--tag' => 'account-migrations']);
        }
        Artisan::call('vendor:publish', [
            '--tag' => ['account-config'],
        ]);
        $this->info('Adminetic account config file published ... ✅');

        if ($this->confirm('Do you wish to run account table migration?')) {
            Artisan::call('migrate');
            Artisan::call('migrate:adminetic-account');
            $this->info('Adminetic account module migration complete ... ✅');
        }
        $this->activeFiscalSeed();
        $this->info('Adminetic account active fiscal year seed complete ... ✅');
        $this->ledgerAccountSeed();
        $this->info('Adminetic account configuration data seed complete ... ✅');
        $this->info('Adminetic Account Installed.');
        $this->info('Star to the admenictic repo would be appreciated.');
    }

    protected function activeFiscalSeed()
    {
        Fiscal::create([
            'name' => Carbon::now()->year,
            'start_date' => Carbon::now()->firstOfYear(),
            'end_date' => Carbon::now()->endOfYear(),
            'interval' => Carbon::now()->firstOfYear()->format('Y-m-d') . ' - ' . Carbon::now()->endOfYear()->format('Y-m-d'),
            'active' => true
        ]);
    }

    protected function ledgerAccountSeed()
    {
        $accounts = [
            [
                'name' => 'Assets',
                'children' => [
                    [
                        'name' => 'Current Assets',
                        'grand_children' => [
                            ['name' => 'Bank'],
                            ['name' => 'Margin Money'],
                            ['name' => 'Prepaid Expenses'],
                            ['name' => 'Cash'],
                        ]
                    ],
                    [
                        'name' => 'Fixed Assets',
                    ],
                    [
                        'name' => 'Intangible Assets',
                    ],
                    [
                        'name' => 'Other Assets',
                    ],
                    [
                        'name' => 'Sundry Assets',
                    ],
                ]
            ],
            [
                'name' => 'Liabilities',
                'children' => [
                    [
                        'name' => 'Current Liabilities',
                        'grand_children' => [
                            ['name' => 'Duties and Taxes'],
                            ['name' => 'TDS On Commissions'],
                            ['name' => 'TDS On Contract'],
                            ['name' => 'TDS On Services'],
                            ['name' => 'TDS On House Rent'],
                            ['name' => 'TDS On Salary'],
                            ['name' => 'TDS On Dividend'],
                            ['name' => 'Advance Income Tax 207879'],
                            ['name' => 'Accounts Payable'],
                            ['name' => 'Bank Overdraft'],
                            ['name' => 'Tax Payable'],
                        ]
                    ],
                    [
                        'name' => 'Non-Current Liabilities',
                    ],
                    [
                        'name' => 'Other Liabilities',
                    ],
                    [
                        'name' => 'Sundry Creditors',
                    ],
                ]
            ],
            [
                'name' => 'Revenue',
                'children' => [
                    [
                        'name' => 'Operating Income',
                        'grand_children' => [
                            ['name' => 'Project Sales'],
                        ]
                    ],
                    [
                        'name' => 'Non-Operating Income',
                    ],
                    [
                        'name' => 'Other Income',
                    ]
                ]
            ],
            [
                'name' => 'Equity',
                'children' => [
                    [
                        'name' => 'Shareholder Equity',
                        'grand_children' => [
                            ['name' => 'Capital'],
                        ]
                    ],
                    [
                        'name' => 'Dividends',
                        'grand_children' => [
                            ['name' => 'Dividend'],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Expense',
                'children' => [
                    [
                        'name' => 'Operating Expenses',
                        'grand_children' => [
                            ['name' => 'Salary Expenses'],
                            ['name' => 'Office Rent'],
                            ['name' => 'Discount'],
                            ['name' => 'Labour Charge'],
                            ['name' => 'Freight Charge'],
                            ['name' => 'Commission'],
                        ]
                    ],
                    [
                        'name' => 'Non-Operating Expenses',
                        'grand_children' => [
                            ['name' => 'Outgoing Tax'],
                            ['name' => 'Labour Tax'],
                            ['name' => 'Freight Tax']
                        ]
                    ],
                    [
                        'name' => 'Cost Of Sales',
                    ],
                ]
            ]
        ];
        ledger_accounts($accounts);
    }
}
