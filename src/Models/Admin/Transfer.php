<?php

namespace Adminetic\Account\Models\Admin;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Transfer extends Model
{
    use LogsActivity;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        $this->table = config('account.table_prefix', 'account') . '_transfers';

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
        Cache::has('transfers') ? Cache::forget('transfers') : '';
    }

    // Logs
    protected static $logName = 'transfer';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
