<div>
    <div wire:loading.remove>
        <button wire:click="toggleApprovedBy" title="{{ is_null($transaction->approved_by) ? 'Approve' : 'Reject' }}"
            class="btn btn-{{ is_null($transaction->approved_by) ? 'success' : 'warning' }} btn-{{ is_null($transaction->approved_by) ? 'success' : 'warning' }}-air btn-sm p-2">
            <i class="{{ is_null($transaction->approved_by) ? 'fa fa-check' : 'fa fa-user-times' }}"></i>
        </button>
    </div>
    <div wire:loading>
        <button wire:click="toggleApprovedBy" disabled
            class="btn btn-{{ is_null($transaction->approved_by) ? 'success' : 'warning' }} btn-{{ is_null($transaction->approved_by) ? 'success' : 'warning' }}-air btn-sm p-2">
            <i class="fas fa-spinner fa-spin"></i>
        </button>
    </div>
</div>
