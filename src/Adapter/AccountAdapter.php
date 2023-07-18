<?php

namespace Adminetic\Account\Adapter;

use Pratiksh\Adminetic\Contracts\PluginInterface;
use Pratiksh\Adminetic\Traits\SidebarHelper;

class AccountAdapter implements PluginInterface
{
    use SidebarHelper;

    public function assets(): array
    {
        return  [
            [
                'name' => 'PrintThis',
                'active' => true,
                'files' => [
                    [
                        'type' => 'js',
                        'active' => true,
                        'location' => 'adminetic/assets/js/printThis.js',
                    ],
                ],
            ],
            [
                'name' => 'HTML To Canvas',
                'active' => true,
                'files' => [
                    [
                        'type' => 'js',
                        'active' => true,
                        'location' => 'plugins/html2canvas/script.js',
                    ],
                ],
            ],
        ];
    }

    public function myMenu(): array
    {
        return [
            [
                'type' => 'breaker',
                'name' => 'Account',
            ],
            [
                'type' => 'breaker',
                'name' => 'Configuration',
            ],
            [
                'type' => 'menu',
                'name' => 'Ledger',
                'icon' => 'fa fa-book',
                'is_active' => request()->routeIs('ledger*') ? 'active' : '',
                'conditions' => [
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('view-any', \Adminetic\Account\Models\Admin\Ledger::class),
                    ],
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('create', \Adminetic\Account\Models\Admin\Ledger::class),
                    ],
                ],
                "children" => $this->indexCreateChildren("ledger", \Adminetic\Account\Models\Admin\Ledger::class),

            ], [
                'type' => 'menu',
                'name' => 'Fiscal',
                'icon' => 'fa fa-calendar',
                'is_active' => request()->routeIs('fiscal*') ? 'active' : '',
                'conditions' => [
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('view-any', \Adminetic\Account\Models\Admin\Fiscal::class),
                    ],
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('create', \Adminetic\Account\Models\Admin\Fiscal::class),
                    ],
                ],
                "children" => $this->indexCreateChildren("fiscal", \Adminetic\Account\Models\Admin\Fiscal::class),

            ], [
                'type' => 'menu',
                'name' => 'Transfer',
                'icon' => 'fa fa-exchange-alt',
                'is_active' => request()->routeIs('transfer*') ? 'active' : '',
                'conditions' => [
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('view-any', \Adminetic\Account\Models\Admin\Transfer::class),
                    ],
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('create', \Adminetic\Account\Models\Admin\Transfer::class),
                    ],
                ],
                "children" => $this->indexCreateChildren("transfer", \Adminetic\Account\Models\Admin\Transfer::class),

            ], [
                'type' => 'menu',
                'name' => 'Account',
                'icon' => 'fa fa-cube',
                'is_active' => request()->routeIs('account*') ? 'active' : '',
                'conditions' => [
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('view-any', \Adminetic\Account\Models\Admin\Account::class),
                    ],
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('create', \Adminetic\Account\Models\Admin\Account::class),
                    ],
                ],
                "children" => $this->indexCreateChildren("account", \Adminetic\Account\Models\Admin\Account::class),

            ],
            [
                'type' => 'link',
                'icon' => 'fa fa-money-bill-wave-alt',
                'name' => 'Income/Expense Subjects',
                'link' => route('admin.entities.income_expense_subjects'),
            ],
            [
                'type' => 'link',
                'icon' => 'fa fa-book-open',
                'name' => 'Ledger Accounts',
                'link' => route('admin.entities.ledger_accounts'),
            ],
            [
                'type' => 'breaker',
                'name' => 'Entry',
            ],
            [
                'type' => 'menu',
                'name' => 'Journal',
                'icon' => 'fa fa-file-excel',
                'is_active' => request()->routeIs('journal*') ? 'active' : '',
                'conditions' => [
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('view-any', \Adminetic\Account\Models\Admin\Journal::class),
                    ],
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('create', \Adminetic\Account\Models\Admin\Journal::class),
                    ],
                ],
                "children" => $this->indexCreateChildren("journal", \Adminetic\Account\Models\Admin\Journal::class),

            ],  [
                'type' => 'menu',
                'name' => 'Transaction',
                'icon' => 'fa fa-piggy-bank',
                'is_active' => request()->routeIs('transaction*') ? 'active' : '',
                'conditions' => [
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('view-any', \Adminetic\Account\Models\Admin\Transaction::class),
                    ],
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('create', \Adminetic\Account\Models\Admin\Transaction::class),
                    ],
                ],
                "children" => $this->indexCreateChildren("transaction", \Adminetic\Account\Models\Admin\Transaction::class),

            ],
            [
                'type' => 'link',
                'name' => 'Entries',
                'icon' => 'fa fa-keyboard',
                'link' => adminRedirectRoute('entry'),
            ],
            [
                'type' => 'breaker',
                'name' => 'Double Entry',
            ],
            [
                'type' => 'link',
                'icon' => 'fa fa-chart-line',
                'name' => 'Chart Of Accounts',
                'link' => route('admin.report.chart_of_account'),
            ],
            [
                'type' => 'link',
                'icon' => 'fa fa-book-reader',
                'name' => 'Ledger Summary',
                'link' => route('admin.report.ledger_summary'),
            ],
            [
                'type' => 'link',
                'icon' => 'fa fa-file-signature',
                'name' => 'Transaction Report',
                'link' => route('admin.report.transaction_report'),
            ],
            [
                'type' => 'link',
                'icon' => 'fa fa-user-cog',
                'name' => 'User Account Audit',
                'link' => route('admin.report.user_account_audit'),
            ],
            [
                'type' => 'link',
                'icon' => 'fa fa-balance-scale',
                'name' => 'Profit Loss Report',
                'link' => route('admin.report.profit_loss_report'),
            ],
            [
                'type' => 'link',
                'icon' => 'far fa-money-bill-alt',
                'name' => 'Cumulative Balance Report',
                'link' => route('admin.report.cumulative_balance_report'),
            ],
        ];
    }
}
