<div>
    <div class="card">
        <div class="card-body p-0">
            <div class="row chat-box">
                <div class="col pe-0 custom-scrollbar"{{--  style="overflow: auto;height: 75vh;" --}}>
                    <!-- chat start-->
                    <div class="chat">

                        <div class="chat-msg-box custom-scrollbar">
                            {{-- Action Section --}}
                            <div class="card">
                                <div class="card-body p-4">

                                    {{-- Filter --}}
                                    <ul class="chat-menu-icons">
                                        <li class="list-inline-item toogle-bar"><a
                                                class="btn btn-primary btn-air-primary m-1" href="#"
                                                title="Toggle Filter"><i class="icon-menu"></i> Menu</a>
                                        </li>
                                        <b>Ledger Profile</b>
                                    </ul>
                                </div>
                            </div>
                            {{-- Shipment List --}}
                            <div class="card">
                                <div class="card-body shadow-lg p-3">
                                    @if (!is_null($entries))
                                        @if ($entries->count() > 0)
                                            <div class="table-responsive">
                                                <div id="print-container">
                                                    <table class="table-wrapper" style="width:100%" id="journal">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <table class="logo-wrappper" style="width: 100%;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><img src="{{ logo() }}"
                                                                                        alt="logo" width="250">
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
                                                                    <h4 class="text-center">Ledger Summary</h4>
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
                                                                                    <span style="color: #fff;">#</span>
                                                                                </th>
                                                                                <th
                                                                                    style="padding: 10px 15px;text-align: left">
                                                                                    <span
                                                                                        style="color: #fff;">Transaction
                                                                                        Date</span>
                                                                                </th>
                                                                                <th
                                                                                    style="padding: 10px 15px;text-align: left">
                                                                                    <span
                                                                                        style="color: #fff;">Remark</span>
                                                                                </th>
                                                                                <th
                                                                                    style="padding: 10px 15px;text-align: center">
                                                                                    <span style="color: #fff;">Credit
                                                                                        (Cr.)</span>
                                                                                </th>
                                                                                <th
                                                                                    style="padding: 10px 15px;text-align: center">
                                                                                    <span style="color: #fff;">Debit
                                                                                        (Dr.)</span>
                                                                                </th>
                                                                                <th
                                                                                    style="padding: 10px 15px;text-align: center">
                                                                                    <span
                                                                                        style="color: #fff;">Balance</span>
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @if ($entries->count() > 0)
                                                                                @php
                                                                                    $balance = 0;
                                                                                @endphp
                                                                                @foreach ($entries as $entry)
                                                                                    @php
                                                                                        if ($entry->account_type == CREDIT()) {
                                                                                            $balance = $balance + $entry->amount;
                                                                                        } elseif ($entry->account_type == DEBIT()) {
                                                                                            $balance = $balance - $entry->amount;
                                                                                        }
                                                                                    @endphp
                                                                                    <tr
                                                                                        style="box-shadow: 0px 10.9412px 10.9412px rgba(82, 77, 141, 0.04), 0px 9.51387px 7.6111px rgba(82, 77, 141, 0.06), 0px 5.05275px 4.0422px rgba(82, 77, 141, 0.0484671);border-radius: 5.47059px;">
                                                                                        <td
                                                                                            style="padding: 10px 15px;display:flex;align-items: center;gap: 10px;">
                                                                                            <span
                                                                                                title="{{ !is_null($entry->approved_by) ? 'Approved By : ' . $entry->journal->name : 'Not Approved' }}"
                                                                                                style="min-width: 7px;height: 7px;border: 4px solid {{ !is_null($entry->approved_by) ? '#33cc33' : '#cc0000' }};background: #fff;border-radius: 100%;display: inline-block;"></span>
                                                                                            <span>#{{ $entry->code }}</span>
                                                                                        </td>
                                                                                        <td style="padding: 10px 15px;">
                                                                                            <span>{{ modeDate(\Carbon\Carbon::create($entry->journal->issued_date)) }}</span>
                                                                                        </td>
                                                                                        <td style="padding: 10px 15px;">
                                                                                            <span>{!! $entry->particular !!}</span>
                                                                                        </td>
                                                                                        <td
                                                                                            style="padding: 10px 15px;text-align:center">
                                                                                            <span>{{ $entry->account_type == CREDIT() ? currency() . $entry->amount : '-' }}</span>
                                                                                        </td>
                                                                                        <td
                                                                                            style="padding: 10px 15px;text-align:center">
                                                                                            <span>{{ $entry->account_type == DEBIT() ? currency() . $entry->amount : '-' }}</span>
                                                                                        </td>
                                                                                        <td
                                                                                            style="padding: 10px 15px;text-align:center">
                                                                                            {{ ($balance < 0 ? 'Dr.' : 'Cr.') . currency() . abs($balance) }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @endif
                                                                            <tr>
                                                                                <td> </td>
                                                                                <td> </td>
                                                                                <td
                                                                                    style="padding: 5px 0; padding-top: 15px;">
                                                                                    <span
                                                                                        style="color: #52526C;">Credit</span>
                                                                                </td>
                                                                                <td
                                                                                    style="padding: 5px 0;text-align: right;padding-top: 15px;">
                                                                                    <span>{{ currency() . $entries->filter(fn($e) => $e->account_type == CREDIT())->sum('amount') }}</span>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> </td>
                                                                                <td> </td>
                                                                                <td
                                                                                    style="padding: 5px 0;padding-top: 0;">
                                                                                    <span
                                                                                        style="color: #52526C;">Debit</span>
                                                                                </td>
                                                                                <td
                                                                                    style="padding: 5px 0;text-align: right;padding-top: 0;">
                                                                                    <span>{{ currency() . $entries->filter(fn($e) => $e->account_type == DEBIT())->sum('amount') }}</span>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> </td>
                                                                                <td> </td>
                                                                                <td style="padding: 10px 0;"> <span
                                                                                        style="font-weight: 600;">Balance</span>
                                                                                </td>
                                                                                <td
                                                                                    style="padding: 10px 0;text-align: right">
                                                                                    <span
                                                                                        style="font-weight: 600;">{{ currency() . ($entries->filter(fn($e) => $e->account_type == CREDIT())->sum('amount') - $entries->filter(fn($e) => $e->account_type == DEBIT())->sum('amount')) }}</span>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex justify-content-center">
                                                <img src="{{ asset('adminetic/static/not_found.gif') }}"
                                                    alt="No entry Found" class="img-fluid">
                                            </div>
                                        @endif
                                    @else
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('adminetic/static/onloading.gif') }}" alt="No entry"
                                                class="img-fluid">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col ps-0 chat-menu" style="max-width: 500px;">
                    <div class="card">
                        <div class="card-body shadow-lg p-1">
                            <div style="height: 65vh;overflow-y: auto; padding: 10px">
                                <div id="filters">
                                    <label>Date Interval</label> <br>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-clock"></i></span>
                                        <input type="text" id="interval" class="form-control">
                                    </div>
                                    <br>
                                    <label>Account</label> <br>
                                    <select wire:model.debounce.800ms="ledger_account" class="form-control">
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
                                                                    --> {{ $ledger_account_grand_children['name'] }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    <label>Issued By</label> <br>
                                    <select wire:model="issued_by" class="form-control">
                                        <option value="">Select ...</option>
                                        @if ($issued_by_users->count() > 0)
                                            @foreach ($issued_by_users as $issued_by_user)
                                                <option value="{{ $issued_by_user->id }}">{{ $issued_by_user->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label>Approved By</label> <br>
                                    <select wire:model="approved_by" class="form-control">
                                        <option value="">Select ...</option>
                                        @if ($approved_by_users->count() > 0)
                                            @foreach ($approved_by_users as $approved_by_user)
                                                <option value="{{ $approved_by_user->id }}">
                                                    {{ $approved_by_user->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <hr>
                                    <button type="button" wire:click="getEntries" style="width:100%"
                                        class="btn btn-primary btn-air-primary">Get</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('livewire_third_party')
        <script>
            $(function() {
                Livewire.emit('initialize_ledger_profile');
                Livewire.on('initializeLedgerProfile', function() {
                    $('#interval').daterangepicker({
                        locale: {
                            cancelLabel: 'Clear'
                        }
                    });

                    $('#interval').on('apply.daterangepicker', function(ev, picker) {
                        let start_date = new Date($('#interval').data('daterangepicker')
                            .startDate.format('YYYY-MM-DD'));
                        let end_date = new Date($('#interval').data('daterangepicker').endDate
                            .format('YYYY-MM-DD'));
                        window.livewire.emit('date_range_filter', start_date, end_date)
                    });

                    $('#interval').on('cancel.daterangepicker', function(ev, picker) {
                        $(this).val('');
                    });
                });
            });
        </script>
    @endpush
</div>
