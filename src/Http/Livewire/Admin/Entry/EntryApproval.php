<?php

namespace Adminetic\Account\Http\Livewire\Admin\Entry;

use Adminetic\Account\Models\Admin\Entry;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EntryApproval extends Component
{
    public $entry;

    public function mount(Entry $entry)
    {
        $this->entry = $entry;
    }

    public function toggleApprovedBy()
    {
        $this->entry->update([
            'approved_by' => $this->entry->approved_by == Auth::user()->id ? null : Auth::user()->id
        ]);
    }
    public function render()
    {
        return view('account::livewire.admin.entry.entry-approval');
    }
}
