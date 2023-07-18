<?php

namespace Adminetic\Account\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

interface HasJournalEntryInterface
{
    public function representing_name(): string;

    public function ledger_name(): string;

    public function journal(): MorphOne;

    public function transactions(): MorphMany;
}
