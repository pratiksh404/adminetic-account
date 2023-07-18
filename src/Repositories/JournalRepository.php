<?php

namespace Adminetic\Account\Repositories;

use Adminetic\Account\Models\Admin\Journal;
use Illuminate\Support\Facades\Cache;
use Adminetic\Account\Contracts\JournalRepositoryInterface;
use Adminetic\Account\Http\Requests\JournalRequest;
use Adminetic\Account\Models\Admin\Entry;
use Illuminate\Support\Facades\Auth;

class JournalRepository implements JournalRepositoryInterface
{
    // Journal Index
    public function indexJournal()
    {
        $journals = config('adminetic.caching', true)
            ? (Cache::has('journals') ? Cache::get('journals') : Cache::rememberForever('journals', function () {
                return Journal::latest()->get();
            }))
            : Journal::latest()->get();
        return compact('journals');
    }

    // Journal Create
    public function createJournal()
    {
        //
    }

    // Journal Store
    public function storeJournal(JournalRequest $request)
    {
        $journal = Journal::create($request->validated());
        $journal->setEntries();
    }

    // Journal Show
    public function showJournal(Journal $journal)
    {
        return compact('journal');
    }

    // Journal Edit
    public function editJournal(Journal $journal)
    {
        return compact('journal');
    }

    // Journal Update
    public function updateJournal(JournalRequest $request, Journal $journal)
    {
        $journal->update($request->validated());
        $journal->setEntries();
    }

    // Journal Destroy
    public function destroyJournal(Journal $journal)
    {
        $journal->entries()->delete();
        $journal->delete();
    }
}
