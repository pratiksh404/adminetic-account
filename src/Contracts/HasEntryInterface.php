<?php

namespace Adminetic\Account\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphOne;

interface HasEntryInterface
{
    public function entry(): MorphOne;

    public function entryAmountAttribute(): string;
}
