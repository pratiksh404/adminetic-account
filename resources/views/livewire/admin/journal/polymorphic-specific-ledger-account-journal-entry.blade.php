<div>
    @if (auth()->user()->can('create', \Adminetic\Account\Models\Admin\Journal::class) &&
            auth()->user()->can('create', \Adminetic\Account\Models\Admin\Entry::class))
        <div class="card">
            <div class="card-header bg-primary">
                <div class="d-flex justify-content-between">
                    {{ $ledger_account }}
                    <div>
                        <button type="button" class="btn btn-info btn-air-info mx-2"
                            wire:click="$refresh">Refresh</button>
                        <button type="button" class="btn btn-secondary btn-air-secondary mx-2"
                            wire:click="$toggle('toggle_entry_modal')">Add {{ $ledger_account }}</button>
                    </div>
                </div>
            </div>
            <div class="card-body shadow-lg p-3">
                <div class="card">
                    <div class="card-body">
                        {{-- Status Ribbon --}}

                        <div class="ribbon ribbon-primary ribbon-clip-right ribbon-right">{{ $journal->status }}</div>

                        {{-- End Status Ribbon --}}
                        <table class="table-wrapper" style="width:100%" id="journal">
                            <tbody>
                                <tr>
                                    <td>
                                        <table class="logo-wrappper" style="width: 100%;">
                                            <tbody>
                                                <tr>
                                                    <td><img src="{{ logo() }}" alt="logo" width="250">
                                                    </td>
                                                    <td class="address"
                                                        style="text-align: right; color: #52526C;opacity: 0.8; width: 16%;">
                                                        <span>{{ company_address() }}</span><br>
                                                        <span>{{ company_email() }}</span><br>
                                                        <span>VAT {{ vat() }}</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="bill-content" style="width: 100%;">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 36%"><span
                                                            style="color: #52526C;opacity: 0.8;">Bill
                                                            No.</span>
                                                        <h6 style="width: 46%">#{{ $journal->bill_no }}</h6>
                                                    </td>
                                                    <td style="width: 21%;"><span
                                                            style="color: #52526C;opacity: 0.8;">Issued
                                                            Date</span>
                                                        <h6>{{ modeDate(\Carbon\Carbon::create($journal->issued_date)) }}
                                                        </h6>
                                                    </td>
                                                    <td><span style="color: #52526C;opacity: 0.8;">Fiscal</span>
                                                        <h6>{{ $journal->fiscal->name ?? '-' }}</h6>
                                                    </td>
                                                    <td style="text-align: right;"><span
                                                            style="color: #52526C;opacity: 0.8;">Balance</span>
                                                        <h2>{{ currency() . ($journal->info['balance'] ?? 0) }}</h2>
                                                    </td>
                                                </tr>
                                                @if ($journal->journalable)
                                                    <tr>
                                                        <td style="width: 36%">
                                                            <h6 style="width: 63%;padding-top: 20px;">
                                                                {{ $journal->journalable->representing_name() }}</h6>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="order-details"
                                            style="width: 100%;border-collapse: separate;border-spacing: 0 10px;">
                                            <thead>
                                                <tr
                                                    style="background: #7366FF;border-radius: 8px;overflow: hidden;box-shadow: 0px 10.9412px 10.9412px rgba(82, 77, 141, 0.04), 0px 9.51387px 7.6111px rgba(82, 77, 141, 0.06), 0px 5.05275px 4.0422px rgba(82, 77, 141, 0.0484671);border-radius: 5.47059px;">
                                                    <th
                                                        style="padding: 10px 15px;border-top-left-radius: 8px;border-bottom-left-radius: 8px;text-align: left">
                                                        <span style="color: #fff;">Code</span>
                                                    </th>
                                                    <th style="padding: 10px 15px;text-align: left"><span
                                                            style="color: #fff;">Particular</span></th>
                                                    <th style="padding: 10px 15px;text-align: left"><span
                                                            style="color: #fff;">Ledger</span></th>
                                                    <th style="padding: 10px 15px;text-align: center"><span
                                                            style="color: #fff;">Dr.</span></th>
                                                    <th style="padding: 10px 15px;text-align: center"><span
                                                            style="color: #fff;">Cr.</span></th>
                                                    <th style="padding: 10px 15px;text-align: center"><span
                                                            style="color: #fff;">Action</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($entries->count() > 0)
                                                    @foreach ($entries as $entry)
                                                        <tr
                                                            style="box-shadow: 0px 10.9412px 10.9412px rgba(82, 77, 141, 0.04), 0px 9.51387px 7.6111px rgba(82, 77, 141, 0.06), 0px 5.05275px 4.0422px rgba(82, 77, 141, 0.0484671);border-radius: 5.47059px;">
                                                            <td
                                                                style="padding: 10px 15px;display:flex;align-items: center;gap: 10px;">
                                                                <span
                                                                    title="{{ !is_null($entry->approved_by) ? 'Approved By : ' . $entry->approvedBy->name : 'Not Approved' }}"
                                                                    style="min-width: 7px;height: 7px;border: 4px solid {{ !is_null($entry->approved_by) ? '#33cc33' : '#cc0000' }};background: #fff;border-radius: 100%;display: inline-block;"></span>
                                                                <span>#{{ $entry->code }}</span>
                                                            </td>
                                                            <td style="padding: 10px 15px;">
                                                                <span>{!! $entry->particular !!}</span>
                                                            </td>
                                                            <td style="padding: 10px 15px;">
                                                                <span>{{ $entry->ledger->name }}</span>
                                                            </td>
                                                            <td style="padding: 10px 15px;text-align:center">
                                                                <span>{{ $entry->account_type == DEBIT() ? currency() . $entry->amount : '-' }}</span>
                                                            </td>
                                                            <td style="padding: 10px 15px;text-align:center">
                                                                <span>{{ $entry->account_type == CREDIT() ? currency() . $entry->amount : '-' }}</span>
                                                            </td>
                                                            <td style="padding: 10px 15px;text-align:center">
                                                                <div class="d-flex justify-content-center">
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-air-danger btn-sm p-2 mx-2"
                                                                        wire:click="delete({{ $entry }})"><i
                                                                            class="fa fa-trash"></i></button>
                                                                    <button type="button"
                                                                        class="btn btn-warning btn-air-warning btn-sm p-2 mx-2"
                                                                        wire:click="edit({{ $entry }})"><i
                                                                            class="fa fa-edit"></i></button>
                                                                    @livewire('admin.entry.entry-transform-to-transaction', ['entry' => $entry], key($entry->id))
                                                                    @livewire('admin.entry.entry-approval', ['entry' => $entry], key('approval' . $entry->id))
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                <tr>
                                                    <td> </td>
                                                    <td> </td>
                                                    <td style="padding: 5px 0; padding-top: 15px;"> <span
                                                            style="color: #52526C;">Credit</span>
                                                    </td>
                                                    <td style="padding: 5px 0;text-align: right;padding-top: 15px;">
                                                        <span>{{ currency() . $entries->filter(fn($e) => $e->account_type == CREDIT())->sum('amount') }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> </td>
                                                    <td> </td>
                                                    <td style="padding: 5px 0;padding-top: 0;"> <span
                                                            style="color: #52526C;">Debit</span></td>
                                                    <td style="padding: 5px 0;text-align: right;padding-top: 0;">
                                                        <span>{{ currency() . $entries->filter(fn($e) => $e->account_type == DEBIT())->sum('amount') }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> </td>
                                                    <td> </td>
                                                    <td style="padding: 10px 0;"> <span
                                                            style="font-weight: 600;">Balance</span>
                                                    </td>
                                                    <td style="padding: 10px 0;text-align: right"><span
                                                            style="font-weight: 600;">{{ currency() . ($entries->filter(fn($e) => $e->account_type == CREDIT())->sum('amount') - $entries->filter(fn($e) => $e->account_type == DEBIT())->sum('amount')) }}</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr
                                    style="width: 100%; display: flex; justify-content: space-between; margin-top: 12px;">
                                    <td>
                                        @if (!is_null($journal->approved_by))
                                            <h4 class="text-center">{{ $journal->approvedBy->name }}</h4>
                                        @endif
                                        <span
                                            style="display:block;background: rgba(82, 82, 108, 0.3);height: 1px;width: 200px;margin-bottom:10px;"></span><span
                                            style="color: rgba(82, 82, 108, 0.8);">Approved By</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <span style="display: flex; justify-content: end; gap: 15px;"><button type="button"
                                    style="background: rgba(115, 102, 255, 1); color:rgba(255, 255, 255, 1);border-radius: 10px;padding: 18px 27px;font-size: 16px;font-weight: 600;outline: 0;border: 0; text-decoration: none;"
                                    wire:click="print">Print<i class="icon-arrow-right"
                                        style="font-size:13px;font-weight:bold; margin-left: 10px;"></i></button><button
                                    type="button"
                                    style="background: rgba(115, 102, 255, 0.1);color: rgba(115, 102, 255, 1);border-radius: 10px;padding: 18px 27px;font-size: 16px;font-weight: 600;outline: 0;border: 0; text-decoration: none;"
                                    wire:click="download">Download<i class="icon-arrow-right"
                                        style="font-size:13px;font-weight:bold; margin-left: 10px;"></i></button></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($toggle_entry_modal)
            <div class="card"
                style="position: fixed;top: 10vh;right: 5vw;bottom: 0;left: 5vw;z-index: 999;width: 90vw;height: 60vh;overflow: auto">

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="amount">{{ label('entries', 'amount') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    {{ currency() }}
                                </span>
                                <input type="number" class="form-control" wire:model.debounce.500ms="amount"
                                    value="{{ $entry->amount ?? old('amount') }}">
                            </div>
                            @error('amount')
                                <br>
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="name">Source Name</label>
                            <input type="text" wire:model.debounce.500ms="data.source.name" id="name"
                                class="form-control" placeholder="Source Name">
                        </div>
                        <div class="col-lg-4">
                            <label for="email">Source Email</label>
                            <input type="email" wire:model.debounce.500ms="data.source.email" id="email"
                                class="form-control" placeholder="Source Email">
                        </div>
                        <div class="col-lg-4">
                            <label for="name">Source Phone</label>
                            <input type="phone" wire:model.debounce.500ms="data.source.phone" id="phone"
                                class="form-control" placeholder="Source phone">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label for="particular">{{ label('entries', 'particular') }}</label>
                            <div class="input-group">
                                <textarea wire:model.debounce.500ms="particular" id="particular" cols="30" rows="10"
                                    class="form-control"></textarea>
                            </div>
                            @error('particular')
                                <br>
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <input wire:click="{{ $edit_entry ? 'update' : 'save' }}" value="Save"
                        class="btn btn-success btn-air-success">
                    <button type="button" class="btn btn-danger btn-air-danger"
                        wire:click="$toggle('toggle_entry_modal')">Close</button>
                </div>

            </div>
        @endif
        @push('livewire_third_party')
            @include('account::admin.layouts.modules.journal.livewire_scripts.polymorphic_journal_panel_script')
        @endpush
    @endif
</div>
