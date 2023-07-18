<div>
    <div class="input-group">
        @if (!is_null($journal->approved_by))
            <span class="input-group-text">Last Approval By : {{ $journal->approvedBy->name }}</span>
        @endif
        <span class="input-group-text"><button type="button" wire:click="undo"
                class="btn btn-primary btn-air-primary">Undo</button></span>
        <select wire:model="status" class="form-control">
            <option value="{{ \Adminetic\Account\Models\Admin\Journal::PENDING }}">Pending</option>
            <option value="{{ \Adminetic\Account\Models\Admin\Journal::REJECTED }}">Reject</option>
            <option value="{{ \Adminetic\Account\Models\Admin\Journal::ACCEPTED }}">Accept</option>
        </select>
    </div>
    @push('livewire_third_party')
        <script>
            $(function() {
                Livewire.on('journal_approval_success', message => {
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
