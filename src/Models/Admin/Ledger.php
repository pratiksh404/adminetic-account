<?php

namespace Adminetic\Account\Models\Admin;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Ledger extends Model
{
    use LogsActivity;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        $this->table = config('account.table_prefix', 'account') . '_ledgers';

        parent::__construct($attributes);
    }

    // Forget cache on updating or saving and deleting
    public static function boot()
    {
        parent::boot();

        static::saving(function () {
            self::cacheKey();
        });

        static::deleting(function () {
            self::cacheKey();
        });
    }

    // Cache Keys
    private static function cacheKey()
    {
        Cache::has('ledgers') ? Cache::forget('ledgers') : '';
    }

    // Logs
    protected static $logName = 'ledger';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    // Appends
    protected $appends = ['info'];

    // Relationships
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    // Accessors
    public function getInfoAttribute()
    {
        $entries = Entry::where('ledger_id', $this->id)->get();
        $credits = $entries->filter(function ($entry) {
            return $entry->account_type == CREDIT();
        });
        $debits = $entries->filter(function ($entry) {
            return $entry->account_type == DEBIT();
        });
        $credit_total = $credits->sum('amount');
        $debit_total = $debits->sum('amount');
        return [
            'credit_total' => $credit_total,
            'debit_total' => $debit_total,
            'balance' => $credit_total - $debit_total
        ];
    }
}
