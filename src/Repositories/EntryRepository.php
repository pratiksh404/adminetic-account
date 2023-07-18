<?php

namespace Adminetic\Account\Repositories;

use Adminetic\Account\Models\Admin\Entry;
use Adminetic\Account\Models\Admin\Ledger;
use Adminetic\Account\Http\Requests\EntryRequest;
use Illuminate\Support\Facades\Cache;
use Adminetic\Account\Contracts\EntryRepositoryInterface;
use Adminetic\Account\Models\Admin\Journal;

class EntryRepository implements EntryRepositoryInterface
{
    // Entry Index
    public function indexEntry()
    {
        $entries = config('adminetic.caching', true)
            ? (Cache::has('entries') ? Cache::get('entries') : Cache::rememberForever('entries', function () {
                return Entry::latest()->get();
            }))
            : Entry::latest()->get();
        return compact('entries');
    }

    // Entry Create
    public function createEntry()
    {
        $ledgers = Cache::get('ledgers', Ledger::latest()->get());
        $journals = Cache::get('journals', Journal::latest()->get());
        return compact('ledgers', 'journals');
    }

    // Entry Store
    public function storeEntry(EntryRequest $request)
    {
        $entry = Entry::create($request->validated());
    }

    // Entry Show
    public function showEntry(Entry $entry)
    {
        return compact('entry');
    }

    // Entry Edit
    public function editEntry(Entry $entry)
    {
        $ledgers = Cache::get('ledgers', Ledger::latest()->get());
        $journals = Cache::get('journals', Journal::latest()->get());
        return compact('entry', 'ledgers', 'journals');
    }

    // Entry Update
    public function updateEntry(EntryRequest $request, Entry $entry)
    {
        $entry->update($request->validated());
    }

    // Entry Destroy
    public function destroyEntry(Entry $entry)
    {
        $journal = Journal::find($entry->journal_id);
        $entry->delete();
        $journal->setEntries();
    }
}
