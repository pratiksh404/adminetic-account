<div>
    <div class="card">
        <div class="card-body shadow-lg">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header text-center bg-primary text-light">From</div>
                        <div class="card-body shadow-lg p-3">
                            <select name="account_from" wire:model="account_from" id="account_from" class="form-control">
                                <option value="">Select Account</option>
                                @if ($accounts->count() > 0)
                                    @foreach ($accounts as $account)
                                        @if ($account->id != $account_to)
                                            <option value="{{ $account->id }}">No: {{ $account->no }} | Name :
                                                {{ $account->holder_name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @if (!is_null($accountFrom))
                                <hr>
                                <ul class="list-group">
                                    <li class="list-group-item"><b>No : </b> {{ $accountFrom->no }}</li>
                                    <li class="list-group-item"><b>Name : </b> {{ $accountFrom->holder_name }}</li>
                                    <li class="list-group-item"><b>Email : </b> {{ $accountFrom->holder_email }}</li>
                                    <li class="list-group-item"><b>Phone : </b> {{ $accountFrom->holder_phone }}</li>
                                </ul>
                            @endif
                        </div>
                        @if (!is_null($accountFrom))
                            <div class="card-footer bg-primary">
                                <h5>Balance :</h5>
                                <br>
                                <h2> {{ currency() . $accountFrom->balance() }}</h2>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header text-center bg-primary text-light">To</div>
                        <div class="card-body shadow-lg p-3">
                            <select name="account_to" wire:model="account_to" id="account_to" class="form-control">
                                <option value="">Select Account</option>
                                @if ($accounts->count() > 0)
                                    @foreach ($accounts as $account)
                                        @if ($account->id != $account_from)
                                            <option value="{{ $account->id }}">No: {{ $account->no }} | Name :
                                                {{ $account->holder_name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @if (!is_null($accountTo))
                                <hr>
                                <ul class="list-group">
                                    <li class="list-group-item"><b>No : </b> {{ $accountTo->no }}</li>
                                    <li class="list-group-item"><b>Name : </b> {{ $accountTo->holder_name }}</li>
                                    <li class="list-group-item"><b>Email : </b> {{ $accountTo->holder_email }}</li>
                                    <li class="list-group-item"><b>Phone : </b> {{ $accountTo->holder_phone }}</li>
                                </ul>
                            @endif
                        </div>
                        @if (!is_null($accountTo))
                            <div class="card-footer bg-primary">
                                <h5>Balance :</h5>
                                <br>
                                <h2> {{ currency() . $accountTo->balance() }}</h2>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (!is_null($accountFrom))
        <div class="card">
            <div class="card-body shadow-lg p-3">
                <div class="row">
                    <div class="col-12">
                        <label for="amount">{{ label('transactions', 'amount') }}</label>
                        <div class="input-group">
                            <input step="any" type="number" wire:model="amount" name="amount" id="amount"
                                class="form-control" value="{{ $transaction->amount ?? old('amount') }}">
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
    @endif
    <div class="card">
        <div class="card-body shadow-lg p-3">
            <label for="particular">{{ label('transfers', 'particular') }}</label>
            <textarea name="particular" wire:model.defer="particular" id="particular" cols="30" rows="10"
                class="form-control"></textarea>
        </div>
    </div>
    <hr>
    <button type="submit" {{ !$success ? 'disabled' : '' }} class="btn btn-primary btn-air-primary">
        Transfer
    </button>
    @push('livewire_third_party')
        <script>
            $(function() {
                Livewire.on('transfer_error', message => {
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
