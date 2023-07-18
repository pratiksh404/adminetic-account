<div>
    <div class="journal-panel" style="margin-top:10vh">
        <div class="row">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body shadow-lg p-3">
                        <div class="row">
                            <div class="col-lg-4">
                                <img src="{{ logo() }}" class="img-fluid">
                            </div>
                            <div class="col-lg-8">
                                <div class="input-group">
                                    <span class="input-group-text">{{ label('journals', 'bill_no', 'Bill No:') }}</span>
                                    <span class="input-group-text">#</span>
                                    <input type="text" name="bill_no" wire:model="bill_no" id="bill_no"
                                        class="form-control">
                                </div>
                                <br>
                                <div class="input-group">
                                    <span
                                        class="input-group-text">{{ label('journals', 'fiscal_id', 'Fiscal Year') }}</span>
                                    <select name="fiscal_id" id="fiscal_id" class="form-control" wire:model="fiscal_id">
                                        @if ($fiscals->count() > 0)
                                            @foreach ($fiscals as $fiscal)
                                                <option value="{{ $fiscal->id }}">{{ $fiscal->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <br>
                                <div class="input-group">
                                    <span
                                        class="input-group-text">{{ label('journals', 'issued_date', 'Issued Date') }}</span>
                                    <input type="text" name="issued_date" id="issued_date" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        Particular Information
                    </div>
                    <div class="card-body shadow-lg p-3" style="height:35vh;overflow-y:auto">
                        <div class="row">
                            <div class="col-5"><b>Ledger <span class="text-danger">*</span></b></div>
                            <div class="col-3"><b>Ledg Ac</b></div>
                            <div class="col-3"><b>Amount</b></div>
                            <div class="col-1"><button type="button" class="btn btn-success btn-air-success"
                                    wire:click="add"><i class="fa fa-plus"></i></button></div>
                        </div>
                        <hr>
                        @if (count($data ?? []) > 0)
                            @foreach ($data as $index => $d)
                                @if (isset($d['code']))
                                    <small class="text-muted">Code :
                                        {{ $d['code'] ?? '-' }}</small>
                                    <input type="hidden" name="data[{{ $index }}][code]"
                                        wire:model="data.{{ $index }}.code">
                                @endif
                                <div class="row">
                                    <div class="col-5">
                                        <select name="data[{{ $index }}][ledger_id]"
                                            wire:model.debounce.800ms="data.{{ $index }}.ledger_id"
                                            class="form-control">
                                            <option value="">Select</option>
                                            @if ($ledgers->count() > 0)
                                                @foreach ($ledgers as $ledger)
                                                    <option value="{{ $ledger->id }}">{{ $ledger->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <select name="data[{{ $index }}][ledger_account]"
                                            wire:model.debounce.800ms="data.{{ $index }}.ledger_account"
                                            class="form-control">
                                            <option option="">Select ...</option>
                                            @if (count(ledger_accounts() ?? []) > 0)
                                                @foreach (ledger_accounts() as $ledger_account)
                                                    <option value="{{ $ledger_account['name'] }}"
                                                        {{ isset($ledger) ? ($ledger->ledger_account == $ledger_account['name'] ? 'selected' : '') : '' }}>
                                                        {{ $ledger_account['name'] }}</option>
                                                    @if (count($ledger_account['children'] ?? []) > 0)
                                                        @foreach ($ledger_account['children'] as $ledger_account_children)
                                                            <option value="{{ $ledger_account_children['name'] }}"
                                                                {{ isset($ledger) ? ($ledger->ledger_account == $ledger_account_children['name'] ? 'selected' : '') : '' }}>
                                                                -> {{ $ledger_account_children['name'] }}</option>

                                                            @if (count($ledger_account_children['grand_children'] ?? []) > 0)
                                                                @foreach ($ledger_account_children['grand_children'] as $ledger_account_grand_children)
                                                                    <option
                                                                        value="{{ $ledger_account_grand_children['name'] }}"
                                                                        {{ isset($entry) ? ($entry->ledger_account == $ledger_account_grand_children['name'] ? 'selected' : '') : '' }}>
                                                                        -->
                                                                        {{ $ledger_account_grand_children['name'] }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <select name="data[{{ $index }}][account_type]"
                                                    class="form-control"
                                                    wire:model.debounce.800ms="data.{{ $index }}.account_type">
                                                    <option value="{{ DEBIT() }}">Dr</option>
                                                    <option value="{{ CREDIT() }}">Cr</option>
                                                </select>
                                            </span>
                                            <span class="input-group-text">
                                                {{ currency() }}
                                            </span>
                                            <input type="number" class="form-control"
                                                name="data[{{ $index }}][amount]"
                                                wire:model.debounce.800ms="data.{{ $index }}.amount">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <button type="button" class="btn btn-danger btn-air-danger"
                                            wire:click="remove({{ $index }})"><i
                                                class="fa fa-trash"></i></button>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="particular">Particular</label>
                                        <textarea class="form-control" name="data[{{ $index }}][particular]" readonly
                                            wire:model.debounce.800ms="data.{{ $index }}.particular"></textarea>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-body shadow-lg p-2">
                        <label for="remark">{{ label('journals', 'remark') }}</label>
                        <textarea name="remark" id="remark" wire:model="remark" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body shadow-lg p-2 bg-secondary">
                        <div class="text-center">
                            <small>Difference (Cr. - Dr.)</small>
                            <h3>{{ currency() .(array_sum(collect($data)->filter(fn($d) => ($d['account_type'] ?? null) == CREDIT())->pluck('amount')->toArray()) -array_sum(collect($data)->filter(fn($d) => ($d['account_type'] ?? null) == DEBIT())->pluck('amount')->toArray())) }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-primary">Journal Preview</div>
                    <div class="card-body shadow-lg p-3">
                        <div class="d-flex justify-content-between">
                            <img src="{{ logo() }}" width="80">
                            <div>
                                <b>{{ title() }}</b>
                                <br>
                                {{ setting('address', config('adminetic.address', '')) }}
                            </div>
                            <b>VAT : {{ vat() }}</b>
                        </div>
                        <hr>
                        <table class="table table-bordered table-sm">
                            <thead>
                                <th>Particulars</th>
                                <th>Debit({{ currency() }})</th>
                                <th>Credit({{ currency() }})</th>
                            </thead>
                            <tbody>
                                @if (count($data ?? []) > 0)
                                    @foreach ($data as $d)
                                        <tr>
                                            <td>
                                                {!! $d['particular'] ?? '' !!}
                                            </td>
                                            <td>
                                                {{ ($d['account_type'] ?? '') == DEBIT() ? currency() . $d['amount'] : '-' }}
                                            </td>
                                            <td>
                                                {{ ($d['account_type'] ?? '') == CREDIT() ? currency() . $d['amount'] : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-air-primary" style="width: 100%"><span
                        class="text-center">Save</span></button>
            </div>
        </div>
    </div>
    @push('livewire_third_party')
        <script>
            $(function() {
                Livewire.emit('initialize_journal_panel');
                Livewire.on('initializeJournalPanel', function() {
                    $('#issued_date').daterangepicker({
                        locale: {
                            cancelLabel: 'Clear',
                            format: 'YYYY-MM-DD'
                        },
                        singleDatePicker: true,
                        showDropdowns: true,
                        minYear: 2020,
                    });
                })
            });
        </script>
    @endpush
</div>
