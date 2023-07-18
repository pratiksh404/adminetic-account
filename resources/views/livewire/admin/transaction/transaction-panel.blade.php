<div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body shadow-lg p-3">
                    <div class="row">
                        <div class="col-12">
                            <label for="amount">{{ label('transactions', 'amount') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <select wire:model="type" name="type" id="type" class="form-control">
                                        @foreach (Account::transaction_types() as $value => $transaction_type)
                                            <option value="{{ $value }}"
                                                {{ isset($transaction) ? ($transaction->getRawOriginal('type') == $value ? 'selected' : '') : 'selected' }}>
                                                {{ $transaction_type }}</option>
                                        @endforeach
                                    </select>
                                </span>
                                <input step="any" type="number" wire:model.debounce.500ms="amount" name="amount"
                                    id="amount" class="form-control"
                                    value="{{ $transaction->amount ?? old('amount') }}">
                            </div>
                        </div>
                        <br>
                        <div class="mt-5">
                            <div class="input-group">
                                <span class="input-group-text">In Words : {{ currency() }}</span>
                                <input type="text" step="any" class="form-control" readonly
                                    value="{{ (new NumberFormatter('en', NumberFormatter::SPELLOUT))->format($this->amount ?? 0) }}">
                                <span class="input-group-text"> Only /-</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">{{ Account::get_transaction_type($type) ?? 'Custom' }}er's Information</div>
                <div class="card-body shadow-lg p-2">
                    <div class="row">
                        <label for="remark">Name</label>
                        <div class="col-12">
                            <input type="text" wire:model="data.contact.name" name="data[contact][name]"
                                id="contact_name" class="form-control"
                                value="{{ isset($transaction) ? (!is_null($transaction->contact['name']) ? $transaction->contact['name'] : '') : '' }}"
                                placeholder="Contact Person Name">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label for="remark">Email</label>
                        <div class="col-12">
                            <input type="email" wire:model="data.contact.email" name="data[contact][email]"
                                id="contact_email" class="form-control"
                                value="{{ isset($transaction) ? (!is_null($transaction->contact['email']) ? $transaction->contact['email'] : '') : '' }}"
                                placeholder="Contact Person Email">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label for="remark">Phone</label>
                        <div class="col-12">
                            <input type="number" wire:model="data.contact.phone" name="data[contact][phone]"
                                id="contact_phone" class="form-control"
                                value="{{ isset($transaction) ? (!is_null($transaction->contact['phone']) ? $transaction->contact['phone'] : '') : '' }}"
                                placeholder="Contact Person Phone">
                        </div>
                    </div>
                    <br>
                </div>
            </div>
            <div class="card">
                <div class="card-body shadow-lg p-4">
                    <label for="particular">{{ label('transactions', 'particular') }}</label>
                    <textarea wire:model.defer="particular" name="particular" id="particular" cols="30" rows="4"
                        class="form-control">{{ $transaction->particular ?? old('particular') }}</textarea>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body shadow-lg bg-primary p-3">
                    <div class="row">
                        <h3 class="text-center">
                            Issue Date : <br>
                            {{ $issue_date ?? modeDate(\Carbon\Carbon::now()) }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="card">
                @if (!is_null($ac))
                    <div class="card-header bg-primary">
                        <h5>Balance :</h5>
                        <br>
                        <h2> {{ currency() . $ac->balance() }}</h2>
                    </div>
                @endif
                <div class="card-body shadow-lg p-3">
                    <label for="account_id">{{ label('transactions', 'account_id', 'Account') }}</label>
                    <select name="account_id" id="account_id" class="form-control" wire:model="account_id">
                        <option value="">Select Account ..</option>
                        @if ($accounts->count() > 0)
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">No: {{ $account->no }} | Name :
                                    {{ $account->holder_name }}</option>
                            @endforeach
                        @endif
                    </select>
                    @if (!is_null($ac))
                        <hr>
                        <ul class="list-group">
                            <li class="list-group-item"><b>No : </b> {{ $ac->no }}</li>
                            <li class="list-group-item"><b>Name : </b> {{ $ac->holder_name }}</li>
                            <li class="list-group-item"><b>Email : </b> {{ $ac->holder_email }}</li>
                            <li class="list-group-item"><b>Phone : </b> {{ $ac->holder_phone }}</li>
                        </ul>
                    @endif
                </div>
            </div>
            @if ($amount > 0)
                <div class="card">
                    <div class="card-body shadow-lg p-3">
                        <div class="row">
                            <label for="remark">Money Bills</label>
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="bg-dark">
                                        <th class="text-light">Denomination</th>
                                        <th class="text-light">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($money_bills as $money_bill)
                                        <tr>
                                            <td>{{ $money_bill }} x </td>
                                            <td><input type="number" class="form-control"
                                                    name="data[assigned_money_bill][{{ $money_bill }}]"
                                                    wire:model="assigned_money_bill.{{ $money_bill }}"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
            <div class="card">
                <div class="card-body shadow-lg p-3">
                    <div class="row">
                        <label for="remark">{{ label('transactions', 'remark') }}</label>
                        <div class="col-12">
                            <textarea wire:model.defer="remark" name="remark" id="remark" cols="30" rows="10"
                                class="form-control">{{ $transaction->remark ?? old('particular') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" {{ !$success ? 'disabled' : '' }}
                class="btn btn-primary btn-air-primary">{{ !is_null($transaction) ? 'Edit' : '' }}
                {{ Account::get_transaction_type($type) }} </button>
        </div>
    </div>
    @push('livewire_third_party')
        <script>
            $(function() {
                Livewire.on('transaction_error', message => {
                    var notify_allow_dismiss = Boolean(
                        {{ config('adminetic.notify_allow_dismiss', true) }});
                    var notify_delay = {{ config('adminetic.notify_delay', 2000) }};
                    var notify_showProgressbar = Boolean(
                        {{ config('adminetic.notify_showProgressbar', true) }});
                    var notify_timer = {{ config('adminetic.notify_timer', 300) }};
                    var notify_newest_on_top = Boolean(
                        {{ config('adminetic.notify_newest_on_top', true) }});
                    var notify_mouse_over = Boolean(
                        {{ config('adminetic.notify_mouse_over', true) }});
                    var notify_spacing = {{ config('adminetic.notify_spacing', 1) }};
                    var notify_notify_animate_in =
                        "{{ config('adminetic.notify_animate_in', 'animated fadeInDown') }}";
                    var notify_notify_animate_out =
                        "{{ config('adminetic.notify_animate_out', 'animated fadeOutUp') }}";
                    var notify = $.notify({
                        title: "<i class='{{ config('adminetic.notify_icon', 'fa fa-bell-o') }}'></i> " +
                            "Alert",
                        message: message
                    }, {
                        type: 'danger',
                        allow_dismiss: notify_allow_dismiss,
                        delay: notify_delay,
                        showProgressbar: notify_showProgressbar,
                        timer: notify_timer,
                        newest_on_top: notify_newest_on_top,
                        mouse_over: notify_mouse_over,
                        spacing: notify_spacing,
                        animate: {
                            enter: notify_notify_animate_in,
                            exit: notify_notify_animate_out
                        }
                    });
                });
            });
        </script>
    @endpush
</div>
