<?php

namespace Adminetic\Account\Rules;

use Adminetic\Account\Models\Admin\Transaction;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AmountTransactionRule implements ValidationRule
{
    public $balance;

    protected $type;

    public function __construct($balance, $type)
    {
        $this->balance = $balance;
        $this->type = $type;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->type == Transaction::WITHDRAW) {
            if ($this->balance < $value) {
                $fail('Not sufficient balance.');
            }
        }
    }
}
