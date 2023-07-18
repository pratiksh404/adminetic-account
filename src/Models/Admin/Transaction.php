<?php

namespace Adminetic\Account\Models\Admin;

use Carbon\Carbon;
use NumberFormatter;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Cache;
use Adminetic\Account\Facades\Account;
use Illuminate\Database\Eloquent\Model;
use Adminetic\Account\Models\Admin\Account as Ac;
use Adminetic\Account\Models\Admin\Entry;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends Model
{
    use LogsActivity;

    const DEPOSIT = 1;
    const WITHDRAW = 0;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        $this->table = config('account.table_prefix', 'account') . '_transactions';

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
        Cache::has('transactions') ? Cache::forget('transactions') : '';
    }

    // Logs
    protected static $logName = 'transaction';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    protected $appends = ['transaction_in_word', 'contact'];

    protected $casts = ['data' => 'array'];

    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }

    // Accessors
    public function getIssueDateAttribute($attribute)
    {
        return modeDate(!is_null($attribute) ? Carbon::create($attribute) : $this->created_at);
    }
    public function getContactAttribute()
    {
        return isset($this->data['contact']) ? $this->data['contact'] : null;
    }
    public function getTransactionInWordAttribute()
    {
        $in_word = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return $in_word->format($this->amount);
    }
    public function getTypeAttribute($attribute)
    {
        return in_array($attribute ?? null, [1, 2])
            ? [
                1 => 'Credit',
                2 => 'Debit'
            ][$attribute]
            : null;
    }

    // Helper Method
    public function getTypeColor()
    {
        $attribute = $this->getRawOriginal('type');
        return in_array($attribute ?? null, [1, 2])
            ? [
                1 => 'success',
                2 => 'danger'
            ][$attribute]
            : null;
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function account()
    {
        return $this->belongsTo(Ac::class, 'account_id');
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function types()
    {
        return (new Account)->transaction_types();
    }

    // Helper Function
    public function account_balance()
    {
        $transactions = Transaction::where('id', '<=', $this->id)->get();
        $deposits = $transactions->filter(fn ($t) => $t->getRawOriginal('type') == Transaction::DEPOSIT)->sum('amount');
        $withdraws = $transactions->filter(fn ($t) => $t->getRawOriginal('type') == Transaction::WITHDRAW)->sum('amount');
        $send_transfers = $this->account->send_transfers->filter(fn ($transfer) => (Carbon::create($this->issued_date))->greaterThanOrEqualTo($transfer->created_at));
        $send_transfers_total = $send_transfers->sum('amount');
        $received_transfers = $this->account->received_transfers->filter(fn ($transfer) => (Carbon::create($this->issued_date))->greaterThanOrEqualTo($transfer->created_at));
        $received_transfers_total = $received_transfers->sum('amount');

        return ($deposits + $received_transfers_total) - ($withdraws + $send_transfers_total);
    }
}
