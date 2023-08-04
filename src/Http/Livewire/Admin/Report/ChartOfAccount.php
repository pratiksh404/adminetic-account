<?php

namespace Adminetic\Account\Http\Livewire\Admin\Report;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Adminetic\Account\Models\Admin\Entry;
use Adminetic\Account\Models\Admin\Ledger;

class ChartOfAccount extends Component
{
    public $ledger_account_wise_data;
    public $credit_total;
    public $debit_total;
    public $balance;

    public $ledger_id;
    public $start_date;
    public $end_date;
    public $issued_by;

    // Resource
    public $ledgers;
    public $issued_by_users;

    protected $listeners = ['initialize_chart_of_account' => 'initializeChartOfAccount', 'date_range_filter' => 'dateRangeFilter'];

    public function mount()
    {
        $this->ledgers = Cache::get('ledgers', Ledger::latest()->get());
        $this->issued_by_users = User::find(array_unique(Entry::pluck('issued_by')->toArray()));
        $this->getData();
    }
    public function dateRangeFilter($start_date, $end_date)
    {
        $this->start_date = Carbon::create($start_date);
        $this->end_date = Carbon::create($end_date);

        $this->getData();
    }
    public function updated()
    {
        $this->getData();
    }
    public function initializeChartOfAccount()
    {
        $this->emit('initializeChartOfAccount');
        $this->dispatchBrowserEvent('chart_of_account_pie_chart', $this->ledger_account_wise_data);
    }
    public function render()
    {
        return view('account::livewire.admin.report.chart-of-account');
    }

    private function getData()
    {
        $data = Entry::query();

        $data = $this->getLedgerWiseData($data);

        $data = $this->getDateWiseData($data);

        $this->credit_total = with(clone $data)->where('account_type', CREDIT())->sum('amount');
        $this->debit_total = with(clone $data)->where('account_type', DEBIT())->sum('amount');
        $this->balance = $this->credit_total - $this->debit_total;

        $this->ledger_account_wise_data = ledger_account_wise_data($data);


        $this->initializeChartOfAccount();
    }

    private function getLedgerWiseData($data)
    {
        if (!is_null($this->ledger_id)) {
            return $data->where('ledger_id', $this->ledger_id);
        }
        return $data;
    }

    private function getDateWiseData($data)
    {
        if (!is_null($this->start_date) && !is_null($this->end_date)) {
            return $data->whereBetween('created_at', [$this->start_date, $this->end_date]);
        }
        return $data;
    }
}
