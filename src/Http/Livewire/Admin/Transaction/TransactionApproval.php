<?php

namespace Adminetic\Account\Http\Livewire\Admin\Transaction;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Adminetic\Account\Models\Admin\Transaction;

class TransactionApproval extends Component
{
    public $transaction;

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function toggleApprovedBy()
    {
        $this->transaction->update([
            'approved_by' => $this->transaction->approved_by == Auth::user()->id ? null : Auth::user()->id
        ]);
    }
    public function render()
    {
        return view('account::livewire.admin.transaction.transaction-approval');
    }
}
