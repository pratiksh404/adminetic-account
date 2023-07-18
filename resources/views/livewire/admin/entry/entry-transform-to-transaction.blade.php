<div>
    <button type="button"
        class="btn btn-{{ !is_null($entry->transaction) ? 'info' : 'primary' }} btn-air-{{ !is_null($entry->transaction) ? 'info' : 'primary' }}  btn-sm p-2 mx-2"
        wire:click="$toggle('toggle_entry_transaction_modal')">
        <i class="{{ !is_null($entry->transaction) ? 'fa fa-undo-alt' : 'far fa-paper-plane' }}"></i>
    </button>

    @if ($toggle_entry_transaction_modal)
        <div class="card"
            style="position: fixed;top: 10vh;right: 5vw;bottom: 0;left: 5vw;z-index: 999;width: 90vw;height: 30vh;overflow: auto">
            <div class="card-header">
                {{ !is_null($entry->transaction) ? 'Edit Entry Transaction' : 'Entry Transaction' }}
            </div>
            <div class="card-body">
                Are you sure you want to
                {{ $entry->account_type == CREDIT() ? 'Credit' : ($entry->account_type == DEBIT() ? 'Debit' : 'Transfer') }}
                {{ $entry->amount }} to Account {{ $account->no }}
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <div wire:loading.remove wire:target="transfer,update">
                        <button type="button"
                            class="btn btn-{{ !is_null($entry->transaction) ? 'info' : 'primary' }} btn-air-{{ !is_null($entry->transaction) ? 'info' : 'primary' }}"
                            wire:click="{{ !is_null($entry->transaction) ? 'update' : 'transfer' }}">
                            <i
                                class="{{ !is_null($entry->transaction) ? 'fa fa-undo-alt' : 'far fa-paper-plane' }}"></i>
                            {{ !is_null($entry->transaction) ? 'Update' : 'Transfer' }}
                        </button>
                    </div>
                    <div wire:loading wire:target="transfer,update">
                        <button type="button"
                            class="btn btn-{{ !is_null($entry->transaction) ? 'info' : 'primary' }} btn-air-{{ !is_null($entry->transaction) ? 'info' : 'primary' }}">
                            Processing ...
                        </button>
                    </div>
                    <button type="button" class="btn btn-danger btn-air-danger"
                        wire:click="$toggle('toggle_entry_transaction_modal')">Close</button>
                </div>
            </div>
        </div>
    @endif
</div>
