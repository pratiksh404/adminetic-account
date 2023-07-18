<div>
    <div class="card">
        <div class="card-body shadow-lg">
            <div class="input-group">
                <select wire:model="account_id" class="form-control">
                    <option value="">Select Account ....</option>
                    @isset($accounts)
                        @foreach ($accounts as $ac)
                            <option value="{{ $ac->id }}">#{{ $ac->no }} | Holder {{ $ac->holder_name }}
                            </option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary">
                    Account
                </div>
                <div class="card-body shadow-lg">
                    @if (!is_null($account))
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-clock"></i></span>
                            <input type="text" class="form-control" id="interval">
                        </div>
                        <hr>
                        <div class="card">
                            <div class="card-body shadow-lg bg-primary">
                                Balance
                                <br>
                                <h3>{{ currency() . $account->balance() }}</h3>
                            </div>
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    Account No :
                                    <span class="text-muted">{{ $account->no }}</span>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    Account Holder Name :
                                    <span class="text-muted">{{ $account->holder_name }}</span>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    Account Holder Email :
                                    <span class="text-muted">{{ $account->holder_email }}</span>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    Account Holder Phone :
                                    <span class="text-muted">{{ $account->holder_phone }}</span>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="chat-time group-chat">
                                    <div class="d-flex justify-content-between">
                                        Users :
                                        <ul>
                                            @foreach ($account->users as $user)
                                                <li title="{{ $user->name }}"><img class="img-fluid rounded-circle"
                                                        width="40" src="{{ getProfilePlaceholder($user->profile) }}"
                                                        alt="{{ $user->name }}"></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary">
                    Transaction
                </div>
                <div class="card-body shadow-lg">
                    @if (!is_null($transactions))
                        @if ($transactions->count() > 0)
                            <table class="table-wrapper" style="width:100%" id="journal">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="logo-wrappper" style="width: 100%;">
                                                <tbody>
                                                    <tr>
                                                        <td><img src="{{ logo() }}" alt="logo"
                                                                width="250">
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
                                            <h4 class="text-center">Account # {{ $account->no }} Transactions</h4>
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
                                                            <span style="color: #fff;">Transaction No.</span>
                                                        </th>
                                                        <th style="padding: 10px 15px;text-align: left">
                                                            <span style="color: #fff;">Credit (Cr.)</span>
                                                        </th>
                                                        <th style="padding: 10px 15px;text-align: left">
                                                            <span style="color: #fff;">Debit (Dr.)</span>
                                                        </th>
                                                        <th style="padding: 10px 15px;text-align: left">
                                                            <span style="color: #fff;">Date</span>
                                                        </th>
                                                        <th style="padding: 10px 15px;text-align: center">
                                                            <span style="color: #fff;">Particular</span>
                                                        </th>
                                                        <th style="padding: 10px 15px;text-align: center">
                                                            <span style="color: #fff;">Balance</span>
                                                        </th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($transactions->count() > 0)
                                                        @foreach ($transactions as $transaction)
                                                            <tr
                                                                style="box-shadow: 0px 10.9412px 10.9412px rgba(82, 77, 141, 0.04), 0px 9.51387px 7.6111px rgba(82, 77, 141, 0.06), 0px 5.05275px 4.0422px rgba(82, 77, 141, 0.0484671);border-radius: 5.47059px;">
                                                                <td
                                                                    style="padding: 10px 15px;display:flex;align-items: center;gap: 10px;">
                                                                    <span>#{{ $transaction->code }}</span>
                                                                </td>
                                                                <td style="padding: 10px 15px;text-align:center">
                                                                    <span>{{ $transaction->type == CREDIT() ? currency() . $transaction->amount : '-' }}</span>
                                                                </td>
                                                                <td style="padding: 10px 15px;text-align:center">
                                                                    <span>{{ $transaction->type == DEBIT() ? currency() . $transaction->amount : '-' }}</span>
                                                                </td>
                                                                <td style="padding: 10px 15px;">
                                                                    <span>{{ modeDate(\Carbon\Carbon::create($transaction->issued_date)) }}</span>
                                                                </td>
                                                                <td style="padding: 10px 15px;">
                                                                    <span>{!! $transaction->particular !!}</span>
                                                                </td>
                                                                <td style="padding: 10px 15px;text-align:center">
                                                                    {{ currency() . $transaction->account_balance() }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif

                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('livewire_third_party')
        <script>
            $(function() {
                Livewire.emit('initialize_transaction_report');
                Livewire.on('initializeTransactionReport', function() {
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
