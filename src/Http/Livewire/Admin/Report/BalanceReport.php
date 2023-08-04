<?php

namespace Adminetic\Account\Http\Livewire\Admin\Report;

use Carbon\Carbon;
use Livewire\Component;
use Adminetic\Account\Models\Admin\Entry;

class BalanceReport extends Component
{
    public $entries;
    public $start_date;
    public $end_date;

    protected $listeners = ['initialize_balance_report' => 'initializeBalanceReport', 'date_range_filter' => 'dateRangeFilter'];

    public function initializeBalanceReport()
    {
        $this->emit('initializeBalanceReport');
    }
    public function dateRangeFilter($start_date, $end_date)
    {
        $this->start_date = Carbon::create($start_date);
        $this->end_date = Carbon::create($end_date);

        $this->entries = Entry::whereBetween('created_at', [$this->start_date, $this->end_date])->get();

        if (!is_null($this->entries)) {
            if ($this->entries->count() > 0) {
                $data = [];
                $balance = ($this->entries->first()->account_type == CREDIT() ? $this->entries->first()->balance() - $this->entries->first()->amount : $this->entries->first()->balance() + $this->entries->first()->amount);
                foreach ($this->entries as $entry) {
                    if ($entry->account_type == CREDIT()) {
                        $balance = $balance + $entry->amount;
                    } elseif ($entry->account_type == DEBIT()) {
                        $balance = $balance - $entry->amount;
                    }
                    $data[] = number_format((float)$balance, 2, '.', '');
                }
                $this->dispatchBrowserEvent('entry_sparklines_chart', $data);
            }
        }
    }
    public function print()
    {
        $this->emit('print_report');
    }
    public function download()
    {
        $this->emit('download_report');
    }
    public function render()
    {
        return view('account::livewire.admin.report.balance-report');
    }
}
