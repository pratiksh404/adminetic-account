<?php

namespace Adminetic\Account\Contracts;

use Adminetic\Account\Models\Admin\Journal;
use Adminetic\Account\Http\Requests\JournalRequest;

interface JournalRepositoryInterface
{
    public function indexJournal();

    public function createJournal();

    public function storeJournal(JournalRequest $request);

    public function showJournal(Journal $Journal);

    public function editJournal(Journal $Journal);

    public function updateJournal(JournalRequest $request, Journal $Journal);

    public function destroyJournal(Journal $Journal);
}
