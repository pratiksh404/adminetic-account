<?php

namespace Adminetic\Account\Traits;

use Adminetic\Account\Models\Admin\Account as Ac;

trait HasAccount
{
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function getAccount()
    {
        $account = !is_null($this->account_id) ? Ac::find($this->account_id) : Ac::create([
            'no' => rand(1000000000, 9999999999),
            'holder_name' => $this->name,
            'holder_email' => $this->email
        ]);
        $this->account_id = $account->id;
        $this->save();

        return $account;
    }
}
