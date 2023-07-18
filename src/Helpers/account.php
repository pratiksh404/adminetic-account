<?php

use Carbon\Carbon;
use Adminetic\Account\Models\Admin\Entry;
use Adminetic\Account\Models\Admin\Fiscal;
use Adminetic\Account\Models\Admin\Ledger;
use Illuminate\Support\Facades\Cache;
use Pratiksh\Adminetic\Models\Admin\Data;

/*
    |--------------------------------------------------------------------------
    | Company Info
    |--------------------------------------------------------------------------
    */

if (!function_exists('company_address')) {
    function company_address($default = null)
    {
        return setting('address', config('adminetic.address', $default));
    }
}
if (!function_exists('company_email')) {
    function company_email($default = null)
    {
        return setting('email', config('adminetic.email', $default));
    }
}

if (!function_exists('company_phone')) {
    function company_phone($default = null)
    {
        return setting('phone', config('adminetic.phone', $default));
    }
}

/*
|--------------------------------------------------------------------------
| Date Mode
|--------------------------------------------------------------------------
*/

if (!function_exists('dateMode')) {
    function dateMode()
    {
        $mode = config('school.cache_mode', true) ?
            Cache::has('date_mode') ? Cache::get('date_mode') : Cache::rememberForever('date_mode', function () {
                return setting('date_mode', config('school.date_mode', 'bs'));
            })
            : setting('date_mode', config('school.date_mode', 'bs'));
        return $mode;
    }
}

if (!function_exists('modeDate')) {
    function modeDate(Carbon $date)
    {
        return dateMode() == 'bs' ? nepaliDate($date) : $date->toFormattedDateString();
    }
}


if (!function_exists('currency')) {
    function currency($default = null)
    {
        return setting('currency', $default ?? config('adminetic.currency', '¥'));
    }
}

// Flags

if (!function_exists('income_flag')) {
    function income_flag()
    {
        return config('account.income_flag', 1);
    }
}
if (!function_exists('expense_flag')) {
    function expense_flag()
    {
        return config('account.expense_flag', 1);
    }
}

if (!function_exists('DEBIT')) {
    function DEBIT()
    {
        return config('account.debit', 0);
    }
}
if (!function_exists('CREDIT')) {
    function CREDIT()
    {
        return config('account.credit', 1);
    }
}

// Data
if (!function_exists('ledger_accounts')) {
    function ledger_accounts($content = [])
    {
        return Data::firstOrCreate([
            'name' => 'ledger_accounts'
        ], [
            'content' => $content
        ])->content;
    }
}
if (!function_exists('ledger_account_children')) {
    function ledger_account_children($ledger_account)
    {
        $ledger_accounts = ledger_accounts();
        $children = [];
        foreach ($ledger_accounts as $parent_ledger) {
            if ($parent_ledger['name'] == $ledger_account) {
                if (isset($parent_ledger['children'])) {
                    $children[] = array_column($parent_ledger['children'], 'name');
                }
                break;
            } else {
                if (isset($ledger_account['children'])) {
                    foreach ($ledger_account['children'] as $child_ledger_account) {
                        if ($child_ledger_account['name'] == $ledger_account) {
                            if (isset($child_ledger_account['grand_children'])) {
                                $children[] = array_column($child_ledger_account['grand_children'], 'name');
                            }
                            break;
                        }
                    }
                }
            }
        }
        return $children;
    }
}
if (!function_exists('ledger_account_all_children')) {
    function ledger_account_all_children($ledger_account)
    {
        $ledger_accounts = ledger_accounts();
        $children = [];
        foreach ($ledger_accounts as $parent_ledger) {
            if ($parent_ledger['name'] == $ledger_account) {
                if (isset($parent_ledger['children'])) {
                    $children = array_column($parent_ledger['children'], 'name');
                    foreach ($parent_ledger['children'] as $children_ledger_ac) {
                        if (isset($children_ledger_ac['grand_children'])) {
                            $children = array_merge($children, array_column($children_ledger_ac['grand_children'], 'name'));
                        }
                    }
                }
                break;
            } else {
                if (isset($ledger_account['children'])) {
                    foreach ($ledger_account['children'] as $child_ledger_account) {
                        if ($child_ledger_account['name'] == $ledger_account) {
                            if (isset($child_ledger_account['grand_children'])) {
                                $children = array_merge($children, array_column($child_ledger_account['grand_children'], 'name'));
                            }
                            break;
                        }
                    }
                }
            }
        }
        return $children;
    }
}
if (!function_exists('ledger_account_wise_data')) {
    function ledger_account_wise_data($qry = null)
    {
        $qry = $qry ?? Entry::query();
        $data = [];
        $ledger_data = [];
        $ledger_accounts = ledger_accounts();
        foreach ($ledger_accounts as $ledger_account) {
            $entries_of_ledger_account = with(clone $qry)->whereIn('ledger_account', array_merge([$ledger_account['name']], ledger_account_all_children($ledger_account['name'])));
            $credit = with(clone $entries_of_ledger_account)->where('account_type', CREDIT())->sum('amount');
            $debit = with(clone $entries_of_ledger_account)->where('account_type', DEBIT())->sum('amount');
            $ledger_data = [
                'name' => $ledger_account['name'],
                'credit' => $credit,
                'debit' => $debit,
                'balance' => $credit - $debit,
                'ledgers' => ledger_account_data($ledger_account['name'])
            ];
            if (count($ledger_account['children'] ?? []) > 0) {
                foreach ($ledger_account['children'] as $child_index => $ledger_account_children) {
                    $entries_of_children_ledger_account = with(clone $qry)->whereIn('ledger_account', array_merge([$ledger_account_children['name']], ledger_account_all_children($ledger_account_children['name'])));
                    $credit = with(clone $entries_of_children_ledger_account)->where('account_type', CREDIT())->sum('amount');
                    $debit = with(clone $entries_of_children_ledger_account)->where('account_type', DEBIT())->sum('amount');
                    $ledger_data['children'][] = [
                        'name' => $ledger_account_children['name'],
                        'credit' => $credit,
                        'debit' => $debit,
                        'balance' => $credit - $debit,
                        'ledgers' => ledger_account_data($ledger_account_children['name'])
                    ];
                    if (count($ledger_account_children['grand_children'] ?? []) > 0) {
                        foreach ($ledger_account_children['grand_children'] as $ledger_account_grand_children) {
                            $entries_of_grand_children_ledger_account = with(clone $qry)->where('ledger_account', array_merge([$ledger_account_grand_children['name']], ledger_account_all_children($ledger_account_grand_children['name'])));
                            $credit = with(clone $entries_of_grand_children_ledger_account)->where('account_type', CREDIT())->sum('amount');
                            $debit = with(clone $entries_of_grand_children_ledger_account)->where('account_type', DEBIT())->sum('amount');
                            $ledger_data['children'][$child_index]['grand_children'][] = [
                                'name' => $ledger_account_grand_children['name'],
                                'credit' => $credit,
                                'debit' => $debit,
                                'balance' => $credit - $debit,
                                'ledgers' => ledger_account_data($ledger_account_grand_children['name'])
                            ];
                        }
                    }
                }
            }
            $data[] = $ledger_data;
        }
        return $data;
    }
}

if (!function_exists('ledger_account_data')) {
    function ledger_account_data($ledger_account)
    {
        $entries_qry = Entry::where('ledger_account', $ledger_account);
        $ledgers = Ledger::find(array_unique(with(clone $entries_qry)->pluck('ledger_id')->toArray()));
        $ledgers_data = null;
        if ($ledgers->count() > 0) {

            foreach ($ledgers as $ledger) {
                $ledger_account_entries = Entry::where([
                    ['ledger_id', '=', $ledger->id],
                    ['ledger_account', '=', $ledger_account]
                ])->get();
                $credits = $ledger_account_entries->filter(function ($entry) {
                    return $entry->account_type == CREDIT();
                });
                $debits = $ledger_account_entries->filter(function ($entry) {
                    return $entry->account_type == DEBIT();
                });
                $credit_total = $credits->sum('amount');
                $debit_total = $debits->sum('amount');
                $ledgers_data[$ledger->id] = [
                    'attributes' => $ledger,
                    'name' => $ledger->name,
                    'credit_total' => $credit_total,
                    'debit_total' => $debit_total,
                    'balance' => $credit_total - $debit_total
                ];
            }
        }
        return $ledgers_data;
    }
}
if (!function_exists('active_fiscal')) {
    function active_fiscal()
    {
        if (Fiscal::count() > 0) {
            return Fiscal::where('active', 1)->latest()->first();
        } else {
            return Fiscal::create([
                'name' => \Carbon\Carbon::now()->year,
                'active' => true,
                'start_date' => \Carbon\Carbon::now()->startOfYear(),
                'end_date' => \Carbon\Carbon::now()->endOfYear(),
                'interval' => (\Carbon\Carbon::now()->startOfYear())->format('Y-m-d') . ' - ' . (\Carbon\Carbon::now()->endOfYear())->format('Y-m-d')
            ]);
        }
    }
}
if (!function_exists('vat')) {
    function vat()
    {
        return setting('vat', config('account.vat', '123456789'));
    }
}
if (!function_exists('entry_code')) {
    function entry_code($ledger_id, $journal_id)
    {
        return rand(100000, 999999) . '-' . \Carbon\Carbon::now()->format('Y-m-d') . '-' . $ledger_id . '-' . $journal_id;
    }
}
