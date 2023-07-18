<?php

namespace Adminetic\Account\Http\Livewire\Admin\Journal;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Adminetic\Account\Models\Admin\Entry;
use Adminetic\Account\Models\Admin\Journal;

class JournalApproval extends Component
{
    public $journal;

    public $status;

    public function mount(Journal $journal)
    {
        $this->journal = $journal;
        $this->status = $journal->getRawOriginal('status');
    }

    public function undo()
    {
        Entry::where([
            ['journal_id', $this->journal->id],
            ['approved_by', Auth::user()->id]
        ])->update([
            'approved_by' => null
        ]);

        $this->journal->update([
            'approved_by' => null,
            'status' => Journal::PENDING
        ]);
        $this->emit('journal_approval_success', 'Journal Status Changed Successfully');
    }

    public function updatedStatus()
    {
        if ($this->status == Journal::PENDING) {
            $this->undo();
        } else {

            Entry::where([
                ['journal_id', $this->journal->id],
            ])->update([
                'approved_by' => $this->status == Journal::ACCEPTED ? Auth::user()->id : null
            ]);


            $this->journal->update([
                'approved_by' => Auth::user()->id,
                'status' => $this->status
            ]);
        }
        $this->emit('journal_approval_success', 'Journal Status Changed Successfully');
    }
    public function render()
    {
        return view('account::livewire.admin.journal.journal-approval');
    }
}
