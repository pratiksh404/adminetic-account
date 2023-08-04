<?php

namespace Adminetic\Account\Models\Admin;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Adminetic\Account\Models\Admin\Entry;
use Spatie\Activitylog\Traits\LogsActivity;
use Adminetic\Account\Services\TransactionProcess;
use App\Models\User;

class Journal extends Model
{
    // Status
    const REJECTED = 0;
    const ACCEPTED = 1;
    const PENDING = 2;

    use LogsActivity;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        $this->table = config('account.table_prefix', 'account') . '_journals';

        parent::__construct($attributes);
    }

    // Forget cache on updating or saving and deleting
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            self::cacheKey();
        });

        static::deleting(function () {
            self::cacheKey();
        });
    }

    // Cache Keys
    private static function cacheKey()
    {
        Cache::has('journals') ? Cache::forget('journals') : '';
        Cache::has('entries') ? Cache::forget('entries') : '';
    }

    // Logs
    protected static $logName = 'journal';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    // Casts
    protected $casts = [
        'data' => 'array'
    ];

    // Appends
    protected $appends = ['info'];

    // Relationships
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
    public function fiscal()
    {
        return $this->belongsTo(Fiscal::class);
    }
    public function journalable()
    {
        return $this->morphTo();
    }
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Accessors
    public function getStatusAttribute($attributes)
    {
        return !empty($attribute) ?
            (in_array($attributes, [self::REJECTED, self::ACCEPTED, self::PENDING])
                ? [
                    self::REJECTED => 'Rejected',
                    self::ACCEPTED => 'Accepted',
                    self::PENDING => 'Pending',
                ][$attributes]
                : null) : null;
    }
    public function getInfoAttribute()
    {
        $credit = $this->entries->filter(fn ($e) => $e->type == CREDIT());
        $debit = $this->entries->filter(fn ($e) => $e->type == DEBIT());
        return [
            'credit_total' => $credit->sum('amount'),
            'debit_total' => $debit->sum('amount'),
            'balance' => $credit->sum('amount') - $debit->sum('amount'),
        ];
    }

    public function setDataAccordingToEntry()
    {
        $this->update([
            'data' => $this->entries->toArray()
        ]);
    }

    public function setEntries($ledger_id = null)
    {
        $new_entries = [];
        $old_entries = $this->entries->pluck('id')->toArray();
        if (count($this->data)) {
            foreach ($this->data as $journal_entry) {
                $transaction_process = (new TransactionProcess($journal_entry['amount'], (auth()->user()->getAccount())->id, $this->id, $ledger_id ?? $journal_entry['ledger_id'], $journal_entry['ledger_account'], $journal_entry['account_type']));
                if ($entry = Entry::where('code', $journal_entry['code'])->first()) {
                    $transaction_process->update($entry);
                } else {
                    $entry = $transaction_process->initiate();
                }
                $new_entries[] = $entry->id;
            }
            $to_be_deleted_entries_id = array_diff($old_entries, $new_entries);
            $to_be_deleted_entries = Entry::find($to_be_deleted_entries_id);
            Transaction::whereIn('entry_id', $to_be_deleted_entries->pluck('id')->toArray())->delete();
            foreach ($to_be_deleted_entries as $to_be_deleted_entry) {
                if (!is_null($to_be_deleted_entry->entryable)) {
                    $to_be_deleted_entry->entryable->delete();
                }
            }
            Entry::whereIn('id', $to_be_deleted_entries_id)->delete();
            $this->updateDataEntries();
        }

        return $this->data ?? null;
    }

    public function updateDataEntries()
    {
        if ($this->entries->count() > 0) {
            $data = [];
            foreach ($this->entries as $entry) {
                $data[] = $entry->toArray();
            }
            $this->update([
                'data' => $data
            ]);
        }
    }
}
