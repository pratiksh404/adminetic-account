<?php

namespace Adminetic\Account\Models\Admin;

use App\Models\User;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Adminetic\Account\Models\Admin\Ledger;
use Adminetic\Account\Models\Admin\Journal;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Entry extends Model
{
    use LogsActivity;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        $this->table = config('account.table_prefix', 'account') . '_entries';

        parent::__construct($attributes);
    }

    // Forget cache on updating or saving and deleting
    public static function boot()
    {
        parent::boot();

        static::saving(function () {
            self::cacheKey();
        });

        static::saved(function ($model) {
            $model->journal->setDataAccordingToEntry();
        });

        static::deleting(function ($model) {
            self::cacheKey();
        });

        static::deleted(function ($model) {
            $model->journal->setDataAccordingToEntry();
        });
    }

    // Cache Keys
    private static function cacheKey()
    {
        Cache::has('entries') ? Cache::forget('entries') : '';
    }

    // Logs
    protected static $logName = 'entry';

    // Casts
    protected $casts = ['data' => 'array'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    // Relationships
    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }
    public function ledger()
    {
        return $this->belongsTo(Ledger::class);
    }
    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
    public function entryable(): MorphTo
    {
        return $this->morphTo();
    }

    // Helper Function 
    public function balance()
    {
        $data = Entry::where('id', '<=', $this->id);
        return with(clone $data)->where('account_type', CREDIT())->sum('amount') - with(clone $data)->where('account_type', DEBIT())->sum('amount');
    }
}
