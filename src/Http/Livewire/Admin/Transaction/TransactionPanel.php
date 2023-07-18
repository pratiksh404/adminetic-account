<?php

namespace Adminetic\Account\Http\Livewire\Admin\Transaction;

use NumberFormatter;
use Livewire\Component;
use Adminetic\Account\Models\Admin\Account as Ac;
use Adminetic\Account\Facades\Account;
use Adminetic\Account\Models\Admin\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionPanel extends Component
{
    public $transaction;
    public $accounts;
    public $ac;

    // Attribute
    public $code;
    public $amount = 0;
    public $particular;
    public $remark;
    public $type = 1;
    public $method;
    public $data;
    public $issue_date;
    public $verified_by;
    public $status;
    public $account_id;

    // Money Bills
    public $money_bills = [1000, 500, 100, 50, 20, 10, 5, 2, 1];
    public $assigned_money_bill = [];

    public $success = false;

    public function mount($transaction = null)
    {
        $this->transaction = $transaction;
        $this->accounts = Ac::where('active', 1)->latest()->get();
        $this->setAttributes();
    }

    public function updated()
    {
        $this->setParticular();
        $this->checkBalance();
    }

    public function updatedAccountId()
    {
        $this->ac = Ac::find($this->account_id);
    }

    public function updatedAmount()
    {
        $this->setMoneyBill();
    }

    public function render()
    {
        return view('account::livewire.admin.transaction.transaction-panel');
    }

    public function setAttributes()
    {
        if (!is_null($this->transaction)) {
            $this->code = $this->transaction->code;
            $this->amount = $this->transaction->amount;
            $this->particular = $this->transaction->particular;
            $this->remark = $this->transaction->remark;
            $this->type = $this->transaction->getRawOriginal('type');
            $this->method = $this->transaction->getRawOriginal['method'];
            $this->data = $this->transaction->data;
            $this->issue_date = !is_null($this->transaction->issue_date) ? $this->transaction->issue_date : modeDate(\Carbon\Carbon::now());
            $this->verified_by = $this->transaction->verified_by;
            $this->account_id = $this->transaction->account_id;
            $this->status = $this->transaction->status;
            $this->updatedAccountId();
        } else {
            $this->account_id = Auth::user()->account_id;
        }
    }

    private function setMoneyBill()
    {
        if ($this->amount > 0) {
            $amount = $this->amount;
            foreach ($this->money_bills as $money_bill) {
                $bill_count = (int)($amount / $money_bill);
                $amount = $amount % $money_bill;
                $this->assigned_money_bill[$money_bill] = $bill_count;
            }
        }
    }

    private function setParticular()
    {
        $type = Account::get_transaction_type($this->type);
        $amount = $this->amount;
        $issue_date = $this->issue_date ?? modeDate(\Carbon\Carbon::now());
        $this->particular = Account::transaction_particular($type, $amount, $issue_date, $this->data['contact'] ?? null);
    }

    private function checkBalance()
    {
        if (!is_null($this->amount) && !is_null($this->account_id) && !is_null($this->type)) {
            $ac = Ac::find($this->account_id);
            if ($this->type == Transaction::WITHDRAW) {
                $balance = $ac->balance();
                if ($balance < $this->amount) {
                    $this->success = false;
                    $this->emit('transaction_error', 'Insufficient Balance');
                } else {
                    $this->success = true;
                }
            }
        }
    }
}
