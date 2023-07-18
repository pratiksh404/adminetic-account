<?php

namespace Adminetic\Account\Http\Livewire\Admin\Report;

use Adminetic\Account\Facades\Account;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Adminetic\Account\Models\Admin\Account as Ac;
use Adminetic\Account\Models\Admin\Transaction;
use Carbon\Carbon;

class TransactionReport extends Component
{
    public $account_id;
    public $start_date;
    public $end_date;

    public $account;
    public $limit = 15;

    public $transactions;

    // Resource
    public $accounts;

    protected $listeners = ['date_range_filter' => 'dateRangeFilter', 'initialize_transaction_report' => 'initializeTransactionReport'];

    public function mount()
    {
        $this->accounts = Cache::get('accounts', Ac::latest()->get());
    }
    public function initializeTransactionReport()
    {
        $this->emit('initializeTransactionReport');
    }
    public function dateRangeFilter($start_date, $end_date)
    {
        $this->start_date = Carbon::create($start_date);
        $this->end_date = Carbon::create($end_date);
        $this->getTransactions();
    }
    public function updated()
    {
        $this->getTransactions();
    }
    public function render()
    {
        return view('account::livewire.admin.report.transaction-report');
    }
    private function getTransactions()
    {
        if (!is_null($this->account_id)) {
            $this->account = Ac::find($this->account_id);

            $data = Transaction::where('account_id', $this->account_id);

            $data = $this->getDateWiseTransactions($data);

            $this->transactions = $data->get();

            $this->initializeTransactionReport();;
        }
    }
    private function getDateWiseTransactions($data)
    {
        if (!is_null($this->start_date) && !is_null($this->end_date)) {
            return $data->whereBetween('created_at', [$this->start_date, $this->end_date]);
        }
        return $data;
    }
}
