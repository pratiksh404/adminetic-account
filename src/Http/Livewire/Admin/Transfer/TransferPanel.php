<?php

namespace Adminetic\Account\Http\Livewire\Admin\Transfer;

use Livewire\Component;
use Adminetic\Account\Facades\Account;
use Adminetic\Account\Models\Admin\Account as Ac;
use Illuminate\Support\Facades\Auth;

class TransferPanel extends Component
{
    public $transfer;
    public $accounts;

    // Attributes
    public $account_from;
    public $account_to;
    public $amount;
    public $remark;
    public $particular;

    public $accountFrom;
    public $accountTo;

    public $success = false;

    public function mount($transfer)
    {
        $this->transfer = $transfer;
        $this->accounts = Ac::where('active', 1)->latest()->get();
        $this->setAttribute();
    }

    public function updated()
    {
        if (!is_null($this->account_from) && !is_null($this->account_to) && !is_null($this->amount)) {
            $this->particular = Account::transfer_particular($this->account_from, $this->account_to, $this->amount);
        }
        $this->checkBalance();
    }

    public function updatedAccountTo()
    {
        $this->accountTo = Ac::find($this->account_to);
    }

    public function updatedAccountFrom()
    {
        $this->accountFrom = Ac::find($this->account_from);
    }

    public function render()
    {
        return view('account::livewire.admin.transfer.transfer-panel');
    }

    private function setAttribute()
    {
        if (!is_null($this->transfer)) {
            $this->account_from = $this->transfer->account_from;
            $this->account_to = $this->transfer->account_to;
            $this->amount = $this->transfer->amount;
            $this->remark = $this->transfer->remark;
        } else {
            $this->account_from = Auth::user()->account_id;
        }
    }


    private function checkBalance()
    {
        if (!is_null($this->amount) && !is_null($this->account_from)) {
            $ac = Ac::find($this->account_from);
            $balance = $ac->balance();
            if ($balance < $this->amount) {
                $this->success = false;
                $this->emit('transfer_error', 'Insufficient Balance');
            } else {
                $this->success = true;
            }
        }
    }
}
