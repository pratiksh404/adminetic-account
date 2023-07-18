<?php

namespace Adminetic\Account\Services;

use Pratiksh\Adminetic\Traits\SidebarHelper;
use Pratiksh\Adminetic\Contracts\SidebarInterface;

class MyMenu implements SidebarInterface
{
    use SidebarHelper;

    public function myMenu(): array
    {
        return [
            [
                'type' => 'breaker',
                'name' => 'General',
                'description' => 'Administration Control',

            ],
            [
                'type' => 'link',
                'name' => 'Dashboard',
                'icon' => 'fa fa-home',
                'link' => route('dashboard'),
                'is_active' => request()->routeIs('home') ? 'active' : '',
                'conditions' => [
                    [
                        'type' => 'and',
                        'condition' => auth()->user()->hasRole('admin'),
                    ],
                ],
            ],
            [
                'type' => 'menu',
                'name' => 'User Management',
                'icon' => 'fa fa-users',
                'is_active' => request()->routeIs('user*') ? 'active' : '',
                'pill' => [
                    'class' => 'badge badge-info badge-air-info',
                    'value' => \Adminetic\Account\Models\User::count(),
                ],
                'conditions' => [
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('view-any', \Adminetic\Account\Models\User::class),
                    ],
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('create', \Adminetic\Account\Models\User::class),
                    ],
                ],
                'children' => $this->indexCreateChildren('user', \Adminetic\Account\Models\User::class),
            ],
            [
                'type' => 'menu',
                'name' => 'Role',
                'icon' => 'fa fa-user-tie',
                'is_active' => request()->routeIs('role*') ? 'active' : '',
                'conditions' => [
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('view-any', \Pratiksh\Adminetic\Models\Admin\Role::class),
                    ],
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('create', \Pratiksh\Adminetic\Models\Admin\Role::class),
                    ],
                ],
                'children' => $this->indexCreateChildren('role', \Pratiksh\Adminetic\Models\Admin\Role::class),
            ],
            [
                'type' => 'menu',
                'name' => 'Permission',
                'icon' => 'fa fa-check',
                'is_active' => request()->routeIs('permission*') ? 'active' : '',
                'conditions' => [
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('view-any', \Pratiksh\Adminetic\Models\Admin\Permission::class),
                    ],
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('create', \Pratiksh\Adminetic\Models\Admin\Permission::class),
                    ],
                ],
                'children' => $this->indexCreateChildren('permission', \Pratiksh\Adminetic\Models\Admin\Permission::class),
            ],
            [
                'type' => 'link',
                'name' => 'Setting',
                'icon' => 'fa fa-cog',
                'link' => adminRedirectRoute('setting'),
                'is_active' => request()->routeIs('home') ? 'active' : '',
                'conditions' => [
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('view-any', \Pratiksh\Adminetic\Models\Admin\Setting::class),
                    ],
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('create', \Pratiksh\Adminetic\Models\Admin\Setting::class),
                    ],
                ],
            ],
            [
                'type' => 'menu',
                'name' => 'Preference',
                'icon' => 'fa fa-wrench',
                'is_active' => request()->routeIs('preference*') ? 'active' : '',
                'conditions' => [
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('view-any', \Pratiksh\Adminetic\Models\Admin\Preference::class),
                    ],
                    [
                        'type' => 'or',
                        'condition' => auth()->user()->can('create', \Pratiksh\Adminetic\Models\Admin\Preference::class),
                    ],
                ],
                'children' => $this->indexCreateChildren('preference', \Pratiksh\Adminetic\Models\Admin\Preference::class),
            ],
            [
                'type' => 'link',
                'name' => 'Activities',
                'icon' => 'fa fa-book',
                'is_active' => request()->routeIs('activities*') ? 'active' : '',
                'link' => adminRedirectRoute('activities'),
                'conditions' => [
                    [
                        'type' => 'and',
                        'condition' => auth()->user()->hasRole('admin'),
                    ],
                ],
            ],
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
                'icon' => 'fa fa-wrench',
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
                'icon' => 'fa fa-wrench',
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
                'icon' => 'fa fa-wrench',
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
                'icon' => 'fa fa-wrench',
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
                'name' => 'Income/Expense Subjects',
                'link' => route('admin.entities.income_expense_subjects'),
            ],
            [
                'type' => 'link',
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
                'icon' => 'fa fa-wrench',
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
                'icon' => 'fa fa-wrench',
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
                'link' => adminRedirectRoute('entry'),
            ],
            [
                'type' => 'breaker',
                'name' => 'Double Entry',
            ],
            [
                'type' => 'link',
                'name' => 'Chart Of Accounts',
                'link' => route('admin.report.chart_of_account'),
            ],
            [
                'type' => 'link',
                'name' => 'Ledger Summary',
                'link' => route('admin.report.ledger_summary'),
            ],
            [
                'type' => 'breaker',
                'name' => 'DEV TOOLS',
                'description' => 'Development Environment',
            ],
            [
                'type' => 'menu',
                'name' => 'Builder',
                'conditions' => [
                    [
                        'type' => 'or',
                        'condition' => env('APP_ENV') == 'local'
                    ],
                ],
                'children' => [
                    [
                        'type' => 'submenu',
                        'name' => 'Form Builder 1',
                        'link' => 'http://admin.pixelstrap.com/cuba/theme/form-builder-1.html',
                    ],
                    [
                        'type' => 'submenu',
                        'name' => 'Form Builder 2',
                        'link' => 'http://admin.pixelstrap.com/cuba/theme/form-builder-2.html',
                    ],
                    [
                        'type' => 'submenu',
                        'name' => 'Page Builder',
                        'link' => 'http://admin.pixelstrap.com/cuba/theme/pagebuild.html',
                    ],
                    [
                        'type' => 'submenu',
                        'name' => 'Buttom Builder',
                        'link' => 'http://admin.pixelstrap.com/cuba/theme/button-builder.html',
                    ],
                ]
            ],
            [
                'type' => 'menu',
                'name' => 'Documentation',
                'conditions' => [
                    [
                        'type' => 'or',
                        'condition' => env('APP_ENV') == 'local'
                    ],
                ],
                'children' => [
                    [
                        'type' => 'submenu',
                        'name' => 'Frontend Docs',
                        'link' => 'https://docs.pixelstrap.com/cuba/all_in_one/document/index.html',
                    ],
                    [
                        'type' => 'submenu',
                        'name' => 'Adminetic Docs',
                        'link' => 'https://pratikdai404.gitbook.io/adminetic/',
                    ],
                ]
            ],
            [
                'type' => 'link',
                'name' => 'Github',
                'icon' => 'fab fa-github',
                'link' => 'https://github.com/pratiksh404/adminetic',
                'conditions' => [
                    [
                        'type' => 'or',
                        'condition' => env('APP_ENV') == 'local'
                    ],
                ],
            ],
            [
                'type' => 'link',
                'name' => 'Font Awesome',
                'icon' => 'fa fa-font',
                'link' => route('fontawesome'),
                'conditions' => [
                    [
                        'type' => 'or',
                        'condition' => env('APP_ENV') == 'local'
                    ],
                ],
            ],
        ];
    }
}
