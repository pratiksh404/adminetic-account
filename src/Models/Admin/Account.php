<?php

namespace Adminetic\Account\Models\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Account extends Model
{
    use LogsActivity;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        $this->table = config('account.table_prefix', 'account') . '_accounts';

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
        Cache::has('accounts') ? Cache::forget('accounts') : '';
    }

    // Logs
    protected static $logName = 'account';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
    // Relationships
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function send_transfers()
    {
        return $this->hasMany(Transfer::class, 'account_from');
    }
    public function received_transfers()
    {
        return $this->hasMany(Transfer::class, 'account_to');
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Helper Function 
    public function balance($transactions = null)
    {
        $transactions = $transactions ?? $this->transactions;

        $deposits = $transactions->filter(fn ($t) => $t->getRawOriginal('type') == Transaction::DEPOSIT)->sum('amount');
        $withdraws = $transactions->filter(fn ($t) => $t->getRawOriginal('type') == Transaction::WITHDRAW)->sum('amount');

        $send_transfers = $this->send_transfers;
        $send_transfers_total = $send_transfers->sum('amount');
        $received_transfers = $this->received_transfers;
        $received_transfers_total = $received_transfers->sum('amount');

        return ($deposits + $received_transfers_total) - ($withdraws + $send_transfers_total);
    }
}
