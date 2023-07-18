<?php

namespace App\Observers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Adminetic\Account\Facades\Account;
use Adminetic\Account\Models\Admin\Entry;
use Adminetic\Account\Services\JournalEntry;
use Adminetic\Account\Models\Admin\Account as Ac;

class EntryObserver
{
    /**
     * Handle the Entry "created" event.
     *
     * @param  \Adminetic\Account\Models\Admin\Entry  $entry
     * @return void
     */
    public function created(Entry $entry)
    {
        //
    }

    /**
     * Handle the Entry "updated" event.
     *
     * @param  \Adminetic\Account\Models\Admin\Entry  $entry
     * @return void
     */
    public function updated(Entry $entry)
    {
        if ($entry->transaction()->exists()) {
            $entry->transaction->update([
                'amount' => $entry->amount,
                'particular' => Account::transaction_particular($entry->account_type, $entry->amount, modeDate(Carbon::now()), [
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => null
                ]),
                'type' => $entry->account_type,
                'issued_by' => Auth::user()->id,
            ]);
        }

        if (!is_null($entry->entryable)) {
            $amount_attribute = $entry->entryable->entryAmountAttribute();
            if (!is_null($entry->entryable->$amount_attribute)) {
                $entry->entryable()->update([
                    $amount_attribute => $entry->amount
                ]);
            }
        }
    }

    /**
     * Handle the Entry "deleted" event.
     *
     * @param  \Adminetic\Account\Models\Admin\Entry  $entry
     * @return void
     */
    public function deleted(Entry $entry)
    {
        if ($entry->transaction()->exists()) {
            $entry->transaction()->delete();
        }
        if (!is_null($entry->entryable)) {
            $entry->entryable->delete();
        }
    }

    /**
     * Handle the Entry "restored" event.
     *
     * @param  \Adminetic\Account\Models\Admin\Entry  $entry
     * @return void
     */
    public function restored(Entry $entry)
    {
        //
    }

    /**
     * Handle the Entry "force deleted" event.
     *
     * @param  \Adminetic\Account\Models\Admin\Entry  $entry
     * @return void
     */
    public function forceDeleted(Entry $entry)
    {
        //
    }
}
