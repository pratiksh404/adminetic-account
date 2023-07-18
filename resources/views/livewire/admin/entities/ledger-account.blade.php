<div>
    <div class="d-flex justify-content-between">
        <h4>Ledger Accounts</h4>
        <div>
            <button type="button" class="btn btn-primary btn-air-primary mx-2" wire:click="addParent">Add</button>
            <button class="btn btn-success btn-air-success mx-2" wire:click="save">Save</button>
        </div>
    </div>
    <ul class="list-group mt-2">
        @if (count($data) > 0)
            @foreach ($data as $parent_index => $group)
                <li class="list-group-item">
                    <div class="input-group">
                        <span class="input-group-text">Name</span>
                        <input type="text" class="form-control" wire:model.defer="data.{{ $parent_index }}.name">
                        <span class="input-group-text">
                            <button type="button" class="btn btn-danger btn-air-danger"
                                wire:click="removeParent({{ $parent_index }})"><i class="fa fa-trash"></i></button>
                        </span>
                        <span class="input-group-text">
                            <button type="button" class="btn btn-success btn-air-success"
                                wire:click="addChildren({{ $parent_index }})"><i class="fa fa-plus"></i></button>
                        </span>
                    </div>
                    @if (isset($group['children']))
                        @if (count($group['children']) > 0)
                            <hr>
                            <ul class="list-group mt-3">
                                @foreach ($group['children'] as $child_index => $group_children)
                                    <li>
                                        <div class="input-group">
                                            <span class="input-group-text">Children</span>
                                            <span class="input-group-text">Name</span>
                                            <input type="text" class="form-control"
                                                wire:model.defer="data.{{ $parent_index }}.children.{{ $child_index }}.name">
                                            <span class="input-group-text">
                                                <button type="button" class="btn btn-danger btn-air-danger"
                                                    wire:click="removeChildren({{ $parent_index }},{{ $child_index }})"><i
                                                        class="fa fa-trash"></i></button>
                                            </span>
                                            <span class="input-group-text">
                                                <button type="button" class="btn btn-success btn-air-success"
                                                    wire:click="addGrandChildren({{ $parent_index }},{{ $child_index }})"><i
                                                        class="fa fa-plus"></i></button>
                                            </span>
                                        </div>
                                    </li>
                                    @if (isset($group_children['grand_children']))
                                        @if (count($group_children['grand_children']) > 0)
                                            <ul class="list-group mt-3 mb-3">
                                                @foreach ($group_children['grand_children'] as $grand_child_index => $group_grand_children)
                                                    <li>
                                                        <div class="input-group">
                                                            <span class="input-group-text">Grand Children</span>
                                                            <span class="input-group-text">Name</span>
                                                            <input type="text" class="form-control"
                                                                wire:model.defer="data.{{ $parent_index }}.children.{{ $child_index }}.grand_children.{{ $grand_child_index }}.name">
                                                            <span class="input-group-text">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-air-danger"
                                                                    wire:click="removeGrandChildren({{ $parent_index }},{{ $child_index }},{{ $grand_child_index }})"><i
                                                                        class="fa fa-trash"></i></button>
                                                            </span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    @endif
                </li>
            @endforeach
        @endif
    </ul>
    @push('livewire_third_party')
        <script>
            $(function() {
                Livewire.on('ledger_account_success', message => {
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
