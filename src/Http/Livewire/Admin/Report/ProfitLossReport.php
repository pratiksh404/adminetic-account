<?php

namespace Adminetic\Account\Http\Livewire\Admin\Report;

use Carbon\Carbon;
use Livewire\Component;
use Adminetic\Account\Facades\Account;
use Adminetic\Account\Models\Admin\Entry;

class ProfitLossReport extends Component
{
    public $profit_total;
    public $loss_total;

    public $profits;
    public $losses;
    public $profit_loss_balance;

    public $start_date;
    public $end_date;

    protected $listeners = ['date_range_filter' => 'dateRangeFilter', 'initialize_profit_loss_report' => 'initializeProfitLossReport'];

    public function mount()
    {
        $this->start_date = Carbon::now()->subDays(7);
        $this->end_date = Carbon::now();
        $this->getData();
    }
    public function initializeProfitLossReport()
    {
        $this->emit('initializeProfitLossReport');
        $this->getData();
    }
    public function dateRangeFilter($start_date, $end_date)
    {
        $this->start_date = Carbon::create($start_date);
        $this->end_date = Carbon::create($end_date);
        $this->getData();
    }

    public function getData()
    {
        if (!is_null($this->start_date) && !is_null($this->end_date)) {
            $this->profit_loss_balance = Account::profitLossBalance($this->start_date, $this->end_date);
            $this->dispatchBrowserEvent('profit_loss_report', $this->profit_loss_balance);
            $this->profits = Entry::whereBetween('created_at', [$this->start_date, $this->end_date])->where('account_type', CREDIT())->latest()->get();
            $this->losses = Entry::whereBetween('created_at', [$this->start_date, $this->end_date])->where('account_type', DEBIT())->latest()->get();
        }
    }

    public function render()
    {
        return view('account::livewire.admin.report.profit-loss-report');
    }
}
