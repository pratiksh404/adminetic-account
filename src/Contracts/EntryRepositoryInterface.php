<?php

namespace Adminetic\Account\Contracts;

use Adminetic\Account\Models\Admin\Entry;
use Adminetic\Account\Http\Requests\EntryRequest;

interface EntryRepositoryInterface
{
    public function indexEntry();

    public function createEntry();

    public function storeEntry(EntryRequest $request);

    public function showEntry(Entry $Entry);

    public function editEntry(Entry $Entry);

    public function updateEntry(EntryRequest $request, Entry $Entry);

    public function destroyEntry(Entry $Entry);
}
