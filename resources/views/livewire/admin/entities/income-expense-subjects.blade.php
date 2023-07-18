<div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body shadow-lg p-3">
                    <select wire:model="type" class="form-control">
                        <option value="{{ income_flag() }}">Income</option>
                        <option value="{{ expense_flag() }}">Expense</option>
                    </select>
                    <hr>
                    <button class="btn btn-primary btn-air-primary" wire:click="save">
                        <span class="text-center">Save</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body shadow-lg p-3">
                    <div class="row">
                        <div class="col-6">
                            <b class="text-center">Name</b>
                        </div>
                        <div class="col-4">
                            <b class="text-center">Icon</b>
                        </div>
                        <div class="col-1">
                            <b class="text-center">Color</b>
                        </div>
                        <div class="col-1">
                            <button type="button" class="btn btn-success btn-air-success" wire:click="add"><i
                                    class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <hr>
                    @if (count($data ?? []) > 0)
                        @foreach ($data as $index => $d)
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" wire:model.defer="data.{{ $index }}.name"
                                        class="form-control">
                                </div>
                                <div class="col-4">
                                    <input type="text" wire:model.defer="data.{{ $index }}.icon"
                                        class="form-control">
                                </div>
                                <div class="col-1">
                                    <input type="color" wire:model.defer="data.{{ $index }}.color"
                                        class="form-control">
                                </div>
                                <div class="col-1">
                                    <button type="button" class="btn btn-danger btn-air-danger"
                                        wire:click="remove({{ $index }})"> <i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                            <br>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('livewire_third_party')
        <script>
            $(function() {
                Livewire.on('income_expense_subjects_success', message => {
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
                        type: 'success',
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
