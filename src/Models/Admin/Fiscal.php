<?php

namespace Adminetic\Account\Models\Admin;

use Adminetic\Account\Models\Admin\Journal;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Fiscal extends Model
{
    use LogsActivity;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        $this->table = config('account.table_prefix', 'account') . '_fiscals';

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
        Cache::has('fiscals') ? Cache::forget('fiscals') : '';
    }

    // Logs
    protected static $logName = 'fiscal';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    // Relationships
    public function journals()
    {
        return $this->hasMany(Journal::class);
    }
}
