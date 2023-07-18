<?php

namespace Adminetic\Account\Http\Livewire\Admin\Ledger;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Adminetic\Account\Models\Admin\Entry;
use Adminetic\Account\Models\Admin\Ledger;
use Adminetic\Account\Models\Admin\Journal;

class LedgerProfile extends Component
{
    public $ledger;
    public $entries;

    public $start_date;
    public $end_date;
    public $ledger_account;
    public $issued_by;
    public $approved_by;

    public $issued_by_users;
    public $approved_by_users;

    protected $listeners = ['initialize_ledger_profile' => 'initializeLedgerProfile', 'date_range_filter' => 'dateRangeFilter'];

    public function mount(Ledger $ledger)
    {
        $this->ledger = $ledger;
        $this->issued_by_users = User::find(array_unique(Entry::pluck('issued_by')->toArray()));
        $this->approved_by_users = User::find(array_unique(Entry::pluck('approved_by')->toArray()));
    }
    public function initializeLedgerProfile()
    {
        $this->emit('initializeLedgerProfile');
    }
    public function updated()
    {
        $this->getEntries();
    }
    public function dateRangeFilter($start_date, $end_date)
    {
        $this->start_date = Carbon::create($start_date);
        $this->end_date = Carbon::create($end_date);
    }
    public function render()
    {
        return view('account::livewire.admin.ledger.ledger-profile');
    }
    public function getEntries()
    {
        $this->emit('initializeLedgerProfile');

        $data = Entry::with('journal')->where('ledger_id', $this->ledger->id);

        $data = $this->dateWiseEntries($data);

        $data = $this->ledgerAccountWiseEntries($data);

        $data = $this->issuedByWiseEntries($data);

        $data = $this->approvedByWiseEntries($data);

        $this->entries = $data->get();
    }
    private function dateWiseEntries($data)
    {
        if (!is_null($this->start_date) && !is_null($this->end_date)) {
            $entries = Entry::whereIn('journal_id', Journal::whereBetween('issued_date', [$this->start_date, $this->end_date])->pluck('id')->toArray())->pluck('id')->toArray();
            return $data->whereIn('id', $entries);
        }
        return $data;
    }
    private function ledgerAccountWiseEntries($data)
    {
        if (!is_null($this->ledger_account)) {
            return $data->where('ledger_account', $this->ledger_account);
        }
        return $data;
    }
    private function issuedByWiseEntries($data)
    {
        if (!is_null($this->issued_by)) {
            return $data->where('issued_by', $this->issued_by);
        }
        return $data;
    }
    private function approvedByWiseEntries($data)
    {
        if (!is_null($this->approved_by)) {
            return $data->where('approved_by', $this->approved_by);
        }
        return $data;
    }
}
