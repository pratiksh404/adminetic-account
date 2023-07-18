<?php

namespace Adminetic\Account\Services;

use Carbon\Carbon;
use App\Models\User;
use NumberFormatter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Adminetic\Account\Models\Admin\Entry;
use Adminetic\Account\Models\Admin\Transaction;
use Adminetic\Account\Models\Admin\Account as Ac;
use Carbon\CarbonPeriod;

class Account
{
    public function transaction_types()
    {
        return [
            Transaction::WITHDRAW => 'Withdraw',
            Transaction::DEPOSIT => 'Deposit',
        ];
    }
    public function get_transaction_type($transaction_type)
    {
        return in_array($transaction_type ?? null, [Transaction::WITHDRAW, Transaction::DEPOSIT]) ? [
            Transaction::WITHDRAW => 'Withdraw',
            Transaction::DEPOSIT => 'Deposit',
        ][$transaction_type] : null;
    }
    public function transaction_particular($type, $amount, $issue_date, $contact)
    {
        $issue_by = auth()->check() ? auth()->user()->name : User::first()->name;

        $contact_name = !is_null($contact) ? ($contact['name'] ?? null) : null;
        $contact_phone = !is_null($contact) ? ($contact['phone'] ?? null) : null;
        $contact_email = !is_null($contact) ? ($contact['email'] ?? null) : null;

        return currency() . $amount . ' ( ' . (new NumberFormatter('en', NumberFormatter::SPELLOUT))->format($amount ?? 0) . ' ) is ' . strtolower($type) . 'ed ' . (!is_null($contact_name) ? ((' by ' . $contact_name) . (!is_null($contact_email) ? (' email : ' . $contact_email) : '') . (!is_null($contact_phone) ? (' phone : ' . $contact_phone) : '')) : '') . ' issued by ' . $issue_by . ' at ' . $issue_date;
    }
    public function transfer_particular($account_from, $account_to, $amount)
    {
        $issue_by = auth()->check() ? auth()->user()->name : User::first()->name;
        $accountFrom = Ac::find($account_from);
        $accountTo = Ac::find($account_to);

        return currency() . $amount . ' ( ' . (new NumberFormatter('en', NumberFormatter::SPELLOUT))->format($amount ?? 0) . ' ) is transferred from account ' . $accountFrom->no . ' to account ' . $accountTo->no . ' issued by ' . $issue_by .
            ' at ' . modeDate(\Carbon\Carbon::now()) . (\Carbon\Carbon::now())->format('g:i:s a');
    }

    public function profit(Carbon $start_date, Carbon $end_date)
    {
        $data = [];
        $period = CarbonPeriod::create($start_date, $end_date);
        foreach ($period as $date) {
            $data[modeDate($date)] = Entry::where('account_type', CREDIT())->sum('amount');
        }
        return $data;
    }
    public function loss(Carbon $start_date, Carbon $end_date)
    {
        $data = [];
        $period = CarbonPeriod::create($start_date, $end_date);
        foreach ($period as $date) {
            $data[modeDate($date)] = Entry::where('account_type', DEBIT())->sum('amount');
        }
        return $data;
    }
    public function balance(Carbon $start_date, Carbon $end_date)
    {
        $data = [];
        $period = CarbonPeriod::create($start_date, $end_date);
        foreach ($period as $date) {
            $data[modeDate($date)] = Entry::where('account_type', CREDIT())->sum('amount') - Entry::where('account_type', DEBIT())->sum('amount');
        }
        return $data;
    }
    public function profitLossBalance(Carbon $start_date, Carbon $end_date)
    {
        $data = [];
        $period = CarbonPeriod::create($start_date, $end_date);
        foreach ($period as $date) {
            $profit = Entry::whereDate('created_at', $date)->where('account_type', CREDIT())->sum('amount');
            $loss = Entry::whereDate('created_at', $date)->where('account_type', DEBIT())->sum('amount');
            $balance = $profit - $loss;
            $data[modeDate($date)] = [
                'profit' => $profit,
                'loss' => $loss,
                'balance' => $balance,
            ];
        }
        return $data;
    }
    public function cumulativeBalance(Carbon $start_date, Carbon $end_date)
    {
        $data = [];
        $period = CarbonPeriod::create($start_date, $end_date);
        foreach ($period as $date) {
            $latest_entry = Entry::whereDate('created_at', $date)->latest()->first();
            $data[modeDate($date)] = !is_null($latest_entry) ? $latest_entry->balance() : 0;
        }
        return $data;
    }
}
