<?php

namespace Adminetic\Account\Http\Livewire\Admin\Report;

use Adminetic\Account\Facades\Account;
use Carbon\Carbon;
use Livewire\Component;
use Adminetic\Account\Models\Admin\Entry;
use Carbon\CarbonPeriod;

class CumulativeBalanceReport extends Component
{
    public $start_date;
    public $end_date;

    public $entries;
    public $date_wise_cumulative_balances;

    protected $listeners = ['initialize_cumulative_balance_report' => 'initializeCumulativeBalanceReport', 'date_range_filter' => 'dateRangeFilter'];

    public function mount()
    {
        $this->start_date = Carbon::now()->subDays(7);
        $this->end_date = Carbon::now();
        $this->getData();
    }

    public function getData()
    {
        if (!is_null($this->start_date) && !is_null($this->end_date)) {
            $this->entries = Entry::whereBetween('created_at', [$this->start_date, $this->end_date])->get();
            $this->date_wise_cumulative_balances = Account::cumulativeBalance($this->start_date, $this->end_date);
            $this->dispatchBrowserEvent('datewise_cumulative_balance_report', $this->date_wise_cumulative_balances);
        }
    }

    public function initializeCumulativeBalanceReport()
    {
        $this->emit('initializeCumulativeBalanceReport');
        $this->getData();
    }

    public function dateRangeFilter($start_date, $end_date)
    {
        $this->start_date = Carbon::create($start_date);
        $this->end_date = Carbon::create($end_date);
        $this->getData();
    }

    public function render()
    {
        return view('account::livewire.admin.report.cumulative-balance-report');
    }
}
