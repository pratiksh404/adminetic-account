<?php

namespace Adminetic\Account\Http\Livewire\Admin\Report;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Adminetic\Account\Models\Admin\Entry;
use Adminetic\Account\Models\Admin\Ledger;
use Adminetic\Account\Models\Admin\Journal;
use Illuminate\Database\Eloquent\Collection;

class LedgerSummary extends Component
{
    public $entries;
    public $ledger_id;
    public $journal_id;

    public $start_date;
    public $end_date;
    public $ledger_account;
    public $issued_by;
    public $approved_by;

    public $issued_by_users;
    public $approved_by_users;
    public $ledgers;
    public $journals;

    protected $listeners = ['initialize_ledger_profile' => 'initializeLedgerProfile', 'date_range_filter' => 'dateRangeFilter'];

    public function mount()
    {
        $this->issued_by_users = User::find(array_unique(Entry::pluck('issued_by')->toArray()));
        $this->approved_by_users = User::find(array_unique(Entry::pluck('approved_by')->toArray()));
        $this->ledgers = Cache::get('ledgers', Ledger::latest()->get());
        $this->journals = Cache::get('journals', Journal::latest()->get());
    }
    public function initializeLedgerProfile()
    {
        $this->emit('initializeLedgerProfile');
    }
    public function updated()
    {
        $this->getEntries();
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
    public function dateRangeFilter($start_date, $end_date)
    {
        $this->start_date = Carbon::create($start_date);
        $this->end_date = Carbon::create($end_date);
    }
    public function render()
    {
        return view('account::livewire.admin.report.ledger-summary');
    }
    public function getEntries()
    {
        $this->emit('initializeLedgerProfile');

        $data = Entry::with('journal');

        $data = $this->ledgerWiseEntries($data);

        $data = $this->dateWiseEntries($data);

        $data = $this->ledgerAccountWiseEntries($data);

        $data = $this->issuedByWiseEntries($data);

        $data = $this->approvedByWiseEntries($data);

        $data = $this->journalWiseEntries($data);

        $this->entries = $data->get();
    }
    private function ledgerWiseEntries($data)
    {
        if (!is_null($this->ledger_id)) {
            return $data->where('ledger_id', $this->ledger_id);
        }
        return $data;
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
    private function journalWiseEntries($data)
    {
        if ($this->journal_id) {
            return $data->where('journal_id', $this->journal_id);
        }
        return $data;
    }
}
