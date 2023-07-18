<?php

namespace Adminetic\Account\Http\Livewire\Admin\Entities;

use Livewire\Component;
use Pratiksh\Adminetic\Models\Admin\Data;

class LedgerAccount extends Component
{
    public $ledger_accounts;
    public $data;
    public function mount()
    {
        $this->ledger_accounts = Data::firstOrCreate([
            'name' => 'ledger_accounts'
        ], [
            'content' => []
        ]);
        $this->data = $this->ledger_accounts->content;
    }

    public function addParent()
    {
        $this->data[] = [
            'name' => ''
        ];
    }

    public function removeParent($index)
    {
        $data = $this->data;
        unset($data[$index]);
        $this->data = $data;
        $this->save();
    }


    public function addChildren($parent_index)
    {
        $this->data[$parent_index]['children'][] = [
            'name' => ''
        ];
    }

    public function removeChildren($parent_index, $index)
    {
        $data = $this->data;
        unset($data[$parent_index]['children'][$index]);
        $this->data = $data;
        $this->save();
    }

    public function addGrandChildren($parent_index, $child_index)
    {
        $this->data[$parent_index]['children'][$child_index]['grand_children'][] = [
            'name' => ''
        ];
    }

    public function removeGrandChildren($parent_index, $child_index, $index)
    {
        $data = $this->data;
        unset($data[$parent_index]['children'][$child_index]['grand_children'][$index]);
        $this->data = $data;
        $this->save();
    }

    public function save()
    {
        $this->ledger_accounts->update([
            'content' => $this->data
        ]);
        $this->data = $this->ledger_accounts->content;
        $this->emit('ledger_account_success', 'Expense Subject Saved Successfully');
    }


    public function render()
    {
        return view('account::livewire.admin.entities.ledger-account');
    }
}
