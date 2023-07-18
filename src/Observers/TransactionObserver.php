<?php

namespace App\Observers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Adminetic\Account\Facades\Account;
use Adminetic\Account\Models\Admin\Transaction;
use Adminetic\Account\Services\JournalTransaction;
use Adminetic\Account\Models\Admin\Account as Ac;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     *
     * @param  \Adminetic\Account\Models\Admin\Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the Transaction "updated" event.
     *
     * @param  \Adminetic\Account\Models\Admin\Transaction  $transaction
     * @return void
     */
    public function updated(Transaction $transaction)
    {
        if ($transaction->entry()->exists()) {
            $transaction->entry->update([
                'amount' => $transaction->amount,
                'issued_by' => Auth::user()->id,
            ]);
        }
    }

    /**
     * Handle the Transaction "deleted" event.
     *
     * @param  \Adminetic\Account\Models\Admin\Transaction  $transaction
     * @return void
     */
    public function deleted(Transaction $transaction)
    {
        if ($transaction->entry()->exists()) {
            $transaction->entry()->delete();
        }
    }

    /**
     * Handle the Transaction "restored" event.
     *
     * @param  \Adminetic\Account\Models\Admin\Transaction  $transaction
     * @return void
     */
    public function restored(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     *
     * @param  \Adminetic\Account\Models\Admin\Transaction  $transaction
     * @return void
     */
    public function forceDeleted(Transaction $transaction)
    {
        //
    }
}
