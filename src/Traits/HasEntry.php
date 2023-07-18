<?php

namespace Adminetic\Account\Traits;

use Adminetic\Account\Models\Admin\Account as Ac;
use Adminetic\Account\Models\Admin\Entry;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasEntry
{
    public function entry(): MorphOne
    {
        return $this->morphOne(Entry::class, 'entryable');
    }

    public function account()
    {
        return $this->belongsTo(Ac::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
