<?php

namespace Adminetic\Account\Http\Livewire\Admin\Report;

use Adminetic\Account\Facades\Account;
use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Adminetic\Account\Models\Admin\Entry;
use Adminetic\Account\Models\Admin\Ledger;
use Adminetic\Account\Models\Admin\Journal;
use Adminetic\Account\Models\Admin\Account as Ac;
use Adminetic\Account\Models\Admin\Transaction;

class UserAccountAudit extends Component
{
    public $user_id;

    public $limit = 20;
    /*
    |--------------------------------------------------------------------------
    | User Involvement Type
    |--------------------------------------------------------------------------
    | 1 => Approved or Issued
    | 2 => Issued
    | 3 => Approved
    */
    public $type = 1;

    /*
    |--------------------------------------------------------------------------
    | Data Status
    |--------------------------------------------------------------------------
    |
    | 1 => Approved / Pending
    | 2 => Approved
    | 3 => Pending
    */
    public $status;

    public $menus = [
        1 => 'Entries',
        2 => 'Transactions',
    ];
    public $selected_menu;

    // Filters

    // Global
    public $start_date;
    public $end_date;

    // Entries
    public $journal_id;
    public $ledger_id;
    public $ledger_account;


    // Resource
    public $users;
    public $ledgers;
    public $journals;


    protected $listeners = ['initialize_user_account_audit' => 'initializeUserAccountAudit', 'date_range_filter' => 'dateRangeFilter'];

    public function mount()
    {
        $this->users = Cache::get('users', User::latest()->get());
        $this->ledgers = Cache::get('ledgers', Ledger::latest()->get());
        $this->journals = Cache::get('journals', Journal::latest()->get());
    }

    public function updated()
    {
        $this->initializeUserAccountAudit();
    }

    public function initializeUserAccountAudit()
    {
        $this->emit('initializeUserAccountAudit');
    }

    public function dateRangeFilter($start_date, $end_date)
    {
        $this->start_date = Carbon::create($start_date);
        $this->end_date = Carbon::create($end_date);
    }

    public function render()
    {
        $entries = $this->getEntries();
        $transactions = $this->getTransactions();
        return view('account::livewire.admin.report.user-account-audit', compact('entries', 'transactions'));
    }

    private function getTransactions()
    {
        if (!is_null($this->user_id)) {
            if ($this->selected_menu == 2) {
                $data = Transaction::query();
                if ($this->type == 1) {
                    $data = $data->where(fn ($q) => $q->where('issued_by', $this->user_id)->orWhere('approved_by', $this->user_id));
                } elseif ($this->type == 2) {
                    $data = $data->where('issued_by', $this->user_id);
                } elseif ($this->type == 3) {
                    $data = $data->where('approved_by', $this->user_id);
                }
                if ($this->status == 2) {
                    $data = $data->whereNotNull('approved_by');
                } elseif ($this->status == 3) {
                    $data = $data->whereNull('approved_by');
                }

                return $data->paginate($this->limit);
            }
            return null;
        }
        return null;
    }


    private function getEntries()
    {
        if (!is_null($this->user_id)) {
            if ($this->selected_menu == 1) {
                $data = Entry::query();
                if ($this->type == 1) {
                    $data = $data->where(fn ($q) => $q->where('issued_by', $this->user_id)->orWhere('approved_by', $this->user_id));
                } elseif ($this->type == 2) {
                    $data = $data->where('issued_by', $this->user_id);
                } elseif ($this->type == 3) {
                    $data = $data->where('approved_by', $this->user_id);
                }
                if ($this->status == 2) {
                    $data = $data->whereNotNull('approved_by');
                } elseif ($this->status == 3) {
                    $data = $data->whereNull('approved_by');
                }

                // Ledger Account Wise Entries
                $data = $this->ledgerAccountWiseEntries($data);

                // Ledger Wise Entries
                $data = $this->getLedgerWiseEntries($data);

                // Journal Wise Entries
                $data = $this->getJournalWiseEntries($data);

                // Date Wise Entries
                $data = $this->getDateWiseEntries($data);

                return $data->paginate($this->limit);
            }
            return null;
        }
        return null;
    }

    private function ledgerAccountWiseEntries($data)
    {
        if (!is_null($this->ledger_account)) {
            return $data->where('ledger_account', $this->ledger_account);
        }
        return $data;
    }

    private function getLedgerWiseEntries($data)
    {
        if (!is_null($this->ledger_id)) {
            return $data->where('ledger_id', $this->ledger_id);
        }
        return $data;
    }

    private function getJournalWiseEntries($data)
    {
        if (!is_null($this->journal_id)) {
            return $data->where('journal_id', $this->journal_id);
        }
        return $data;
    }

    private function getDateWiseEntries($data)
    {
        if (!is_null($this->start_date) && !is_null($this->end_date)) {
            return $data->whereBetween('created_at', [$this->start_date, $this->end_date]);
        }
        return $data;
    }
}
