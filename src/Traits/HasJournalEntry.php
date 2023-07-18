<?php

namespace Adminetic\Account\Traits;

use Carbon\Carbon;
use Adminetic\Account\Models\Admin\Journal;
use Adminetic\Account\Models\Admin\Transaction;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasJournalEntry
{
    /**
     * Get the post's image.
     */
    public function initializeJournal()
    {
        if (!$this->journal()->exists()) {
            return $this->journal()->create([
                'fiscal_id' => (active_fiscal())->id,
                'issued_date' => Carbon::now(),
                'bill_no' => Journal::where([
                    ['fiscal_id', (active_fiscal())->id],
                ])->max('id') + 1
            ]);
        } else {
            return $this->journal;
        }
    }
    /**
     * Get the post's image.
     */
    public function journal(): MorphOne
    {
        return $this->morphOne(Journal::class, 'journalable');
    }

    // Has Many Polymorphic Transactions
    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
