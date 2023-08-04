<div>
    <div>
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
                                                <li> <b>Chart Of Account</b></li>
                                            </ul>
                                        </div>
                                    </div>
                                    {{-- Shipment List --}}
                                    <div class="card">
                                        <div class="card-body shadow-lg-p-3">
                                            <div class="accordion dark-accordion" id="outlineaccordion">
                                                @foreach ($ledger_account_wise_data as $index => $ledger_account_data)
                                                    <div class="accordion-item accordion-wrapper">
                                                        <h2 class="d-flex justify-content-between  accordion-header"
                                                            id="parent_ledger_account{{ $index }}">
                                                            <button
                                                                class="accordion-button accordion-light-primary txt-primary collapsed"
                                                                type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#left-parent_ledger_account{{ $index }}"
                                                                aria-expanded="false"
                                                                aria-controls="left-parent_ledger_account{{ $index }}">

                                                                <span class="mx-3">
                                                                    {{ $ledger_account_data['name'] }}
                                                                </span>

                                                                <div>
                                                                    ....................
                                                                    <span style="font-size:15px"
                                                                        class="text-success mx-3">Cr :
                                                                        {{ currency() . $ledger_account_data['credit'] ?? 0 }}</span>
                                                                    |
                                                                    <span style="font-size:15px"
                                                                        class="text-danger mx-3">Dr :
                                                                        {{ currency() . $ledger_account_data['debit'] ?? 0 }}</span>
                                                                    |
                                                                    <span style="font-size:15px"
                                                                        class="text-info mx-3">Balance :
                                                                        {{ currency() . $ledger_account_data['balance'] ?? 0 }}</span>
                                                                </div>
                                                            </button>
                                                        </h2>
                                                        <div class="accordion-collapse collapse"
                                                            id="left-parent_ledger_account{{ $index }}"
                                                            aria-labelledby="parent_ledger_account{{ $index }}"
                                                            data-bs-parent="#outlineaccordion" style="">
                                                            <div class="accordion-body">
                                                                @if (count($ledger_account_data['ledgers'] ?? []) > 0)
                                                                    <table class="table table-bordered table-sm">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Name</th>
                                                                                <th>Credit</th>
                                                                                <th>Debit</th>
                                                                                <th>Balance</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($ledger_account_data['ledgers'] as $ledger_data)
                                                                                <tr>
                                                                                    <td>{{ $ledger_data['name'] ?? '-' }}
                                                                                    </td>
                                                                                    <td>{{ currency() . ($ledger_data['credit_total'] ?? '0') }}
                                                                                    </td>
                                                                                    <td>{{ currency() . ($ledger_data['debit_total'] ?? '0') }}
                                                                                    </td>
                                                                                    <td>{{ currency() . ($ledger_data['balance'] ?? '0') }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                @endif
                                                                @if (count($ledger_account_data['children'] ?? []) > 0)
                                                                    <div class="accordion dark-accordion"
                                                                        id="parent_of_children_ledger_account{{ $index }}">
                                                                        @foreach ($ledger_account_data['children'] as $child_index => $child_ledger_account_data)
                                                                            <div
                                                                                class="accordion-item accordion-wrapper">
                                                                                <h2 class="accordion-header"
                                                                                    id="child_ledger_account{{ $child_index }}">
                                                                                    <button
                                                                                        class="accordion-button accordion-light-primary txt-primary collapsed"
                                                                                        type="button"
                                                                                        data-bs-toggle="collapse"
                                                                                        data-bs-target="#left-child_ledger_account{{ $child_index }}"
                                                                                        aria-expanded="false"
                                                                                        aria-controls="left-child_ledger_account{{ $child_index }}">
                                                                                        <span class="mx-2">
                                                                                            {{ $child_ledger_account_data['name'] }}
                                                                                        </span>
                                                                                        <div>
                                                                                            ....................
                                                                                            <span style="font-size:15px"
                                                                                                class="text-success mx-3">Cr
                                                                                                :
                                                                                                {{ currency() . $child_ledger_account_data['credit'] ?? 0 }}</span>
                                                                                            |
                                                                                            <span style="font-size:15px"
                                                                                                class="text-danger mx-3">Dr
                                                                                                :
                                                                                                {{ currency() . $child_ledger_account_data['debit'] ?? 0 }}</span>
                                                                                            |
                                                                                            <span style="font-size:15px"
                                                                                                class="text-info mx-3">Balance
                                                                                                :
                                                                                                {{ currency() . $child_ledger_account_data['balance'] ?? 0 }}</span>
                                                                                        </div>
                                                                                    </button>
                                                                                </h2>
                                                                                <div class="accordion-collapse collapse"
                                                                                    id="left-child_ledger_account{{ $child_index }}"
                                                                                    aria-labelledby="child_ledger_account{{ $child_index }}"
                                                                                    data-bs-parent="#parent_of_children_ledger_account{{ $child_index }}"
                                                                                    style="">
                                                                                    <div class="accordion-body">
                                                                                        @if (count($child_ledger_account_data['ledgers'] ?? []) > 0)
                                                                                            <table
                                                                                                class="table table-bordered table-sm">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th>Name</th>
                                                                                                        <th>Credit</th>
                                                                                                        <th>Debit</th>
                                                                                                        <th>Balance</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    @foreach ($child_ledger_account_data['ledgers'] as $child_ledger_data)
                                                                                                        <tr>
                                                                                                            <td>{{ $child_ledger_data['name'] ?? '-' }}
                                                                                                            </td>
                                                                                                            <td>{{ currency() . ($child_ledger_data['credit_total'] ?? '0') }}
                                                                                                            </td>
                                                                                                            <td>{{ currency() . ($child_ledger_data['debit_total'] ?? '0') }}
                                                                                                            </td>
                                                                                                            <td>{{ currency() . ($child_ledger_data['balance'] ?? '0') }}
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    @endforeach
                                                                                                </tbody>
                                                                                            </table>
                                                                                        @endif
                                                                                        {{-- Grand Children --}}
                                                                                        @if (count($child_ledger_account_data['grand_children'] ?? []) > 0)
                                                                                            @foreach ($child_ledger_account_data['grand_children'] as $grand_child_index => $grand_child_ledger_account_data)
                                                                                                <div
                                                                                                    class="accordion-item accordion-wrapper">
                                                                                                    <h2 class="accordion-header"
                                                                                                        id="grand_child_ledger_account_data{{ $grand_child_index }}">
                                                                                                        <button
                                                                                                            class="accordion-button accordion-light-primary txt-primary collapsed"
                                                                                                            type="button"
                                                                                                            data-bs-toggle="collapse"
                                                                                                            data-bs-target="#left-grand_child_ledger_account_data{{ $grand_child_index }}"
                                                                                                            aria-expanded="false"
                                                                                                            aria-controls="left-grand_child_ledger_account_data{{ $grand_child_index }}">
                                                                                                            <span
                                                                                                                class="mx-2">
                                                                                                                {{ $grand_child_ledger_account_data['name'] }}
                                                                                                            </span>
                                                                                                            <div>
                                                                                                                ....................
                                                                                                                <span
                                                                                                                    style="font-size:15px"
                                                                                                                    class="text-success mx-3">Cr
                                                                                                                    :
                                                                                                                    {{ currency() . $grand_child_ledger_account_data['credit'] ?? 0 }}</span>
                                                                                                                |
                                                                                                                <span
                                                                                                                    style="font-size:15px"
                                                                                                                    class="text-danger mx-3">Dr
                                                                                                                    :
                                                                                                                    {{ currency() . $grand_child_ledger_account_data['debit'] ?? 0 }}</span>
                                                                                                                |
                                                                                                                <span
                                                                                                                    style="font-size:15px"
                                                                                                                    class="text-info mx-3">Balance
                                                                                                                    :
                                                                                                                    {{ currency() . $grand_child_ledger_account_data['balance'] ?? 0 }}</span>
                                                                                                            </div>
                                                                                                        </button>
                                                                                                    </h2>
                                                                                                    <div class="accordion-collapse collapse"
                                                                                                        id="left-grand_child_ledger_account_data{{ $grand_child_index }}"
                                                                                                        aria-labelledby="grand_child_ledger_account_data{{ $grand_child_index }}"
                                                                                                        data-bs-parent="#parent_of_children_ledger_account{{ $grand_child_index }}"
                                                                                                        style="">
                                                                                                        <div
                                                                                                            class="accordion-body">
                                                                                                            @if (count($grand_child_ledger_account_data['ledgers'] ?? []) > 0)
                                                                                                                <table
                                                                                                                    class="table table-bordered table-sm">
                                                                                                                    <thead>
                                                                                                                        <tr>
                                                                                                                            <th>Name
                                                                                                                            </th>
                                                                                                                            <th>Credit
                                                                                                                            </th>
                                                                                                                            <th>Debit
                                                                                                                            </th>
                                                                                                                            <th>Balance
                                                                                                                            </th>
                                                                                                                        </tr>
                                                                                                                    </thead>
                                                                                                                    <tbody>
                                                                                                                        @foreach ($grand_child_ledger_account_data['ledgers'] as $grand_child_ledger_data)
                                                                                                                            <tr>
                                                                                                                                <td>{{ $grand_child_ledger_data['name'] ?? '-' }}
                                                                                                                                </td>
                                                                                                                                <td>{{ currency() . ($grand_child_ledger_data['credit_total'] ?? '0') }}
                                                                                                                                </td>
                                                                                                                                <td>{{ currency() . ($grand_child_ledger_data['debit_total'] ?? '0') }}
                                                                                                                                </td>
                                                                                                                                <td>{{ currency() . ($grand_child_ledger_data['balance'] ?? '0') }}
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        @endforeach
                                                                                                                    </tbody>
                                                                                                                </table>
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endforeach
                                                                                        @endif
                                                                                        {{-- Grand Children --}}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                    @foreach ($ledger_account_data['children'] as $ledger_account_children)
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col ps-0 chat-menu" style="max-width: 500px;">
                            <div class="card">
                                <div class="card-body shadow-lg p-1">
                                    <div style="height: 65vh;overflow-y: auto; padding: 10px">
                                        <div class="card">
                                            <div class="card-body shadow-lg p-1">
                                                <div id="chart-of-account-pie-chart"></div>
                                            </div>
                                        </div>
                                        <div id="filters p-2">
                                            <div class="card">
                                                <div class="card-body shadow-lg bg-success">
                                                    Credit (Cr.) <br>
                                                    <h3>{{ currency() . $this->credit_total }}</h3>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-body shadow-lg bg-danger">
                                                    Debit (Dr.) <br>
                                                    <h3>{{ currency() . $this->debit_total }}</h3>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-body shadow-lg bg-primary">
                                                    Balance <br>
                                                    <h3>{{ currency() . $this->balance }}</h3>
                                                </div>
                                            </div>
                                            <label for="ledger_id">Ledger</label>
                                            <select wire:model="ledger_id" id="ledgers">
                                                <option value="">Select ..</option>
                                                @if ($ledgers->count() > 0)
                                                    @foreach ($ledgers as $ledger)
                                                        <option value="{{ $ledger->id }}">{{ $ledger->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <br>
                                            <label for="interval">Date Interval</label>
                                            <input type="text" id="interval" class="form-control">
                                            <br>
                                            <label for="issued_by">Issued By</label>
                                            <select class="form-control" wire:model="issued_by">
                                                <option value="">Select ... </option>
                                                @if ($issued_by_users->count() > 0)
                                                    @foreach ($issued_by_users as $issued_by_user)
                                                        <option value="{{ $issued_by_user->id }}">
                                                            {{ $issued_by_user->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
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
                        Livewire.emit('initialize_chart_of_account');
                        Livewire.on('initializeChartOfAccount', function() {
                            initializeChartOfAccount();
                        });

                        function initializeChartOfAccount() {
                            $('#ledgers').select2();
                            $('#ledgers').on('change', function(e) {
                                var data = $('#ledgers').select2("val");
                                @this.set('ledger_id', data);
                            });

                            $('#date').daterangepicker({
                                singleDatePicker: true,
                                locale: {
                                    cancelLabel: 'Clear'
                                }
                            });


                            $('#date').on('apply.daterangepicker', function(ev, picker) {
                                let date = new Date($('#date').data('daterangepicker')
                                    .startDate.format('YYYY-MM-DD'));
                                window.livewire.emit('filter_date', date)
                            });

                            $('#date').on('cancel.daterangepicker', function(ev, picker) {
                                $(this).val('');
                            });

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
                        }

                        window.addEventListener('chart_of_account_pie_chart', event => {
                            $('#chart-of-account-pie-chart').empty();
                            var account = [];
                            var balance = [];
                            var data = event.detail;
                            Object.keys(data).forEach(function(d) {
                                account.push(data[d]['name']);
                                balance.push(data[d]['balance']);
                            });
                            var chartOfAccountPieChartOptions = options = {
                                series: balance,
                                labels: account,
                                chart: {
                                    type: 'polarArea',
                                },
                                stroke: {
                                    colors: ['#fff']
                                },
                                fill: {
                                    opacity: 0.8
                                },
                                responsive: [{
                                    breakpoint: 480,
                                    options: {
                                        chart: {
                                            width: 200
                                        },
                                        legend: {
                                            position: 'bottom'
                                        }
                                    }
                                }]
                            };

                            var chartOfAccountPieChart = new ApexCharts(
                                document.querySelector("#chart-of-account-pie-chart"),
                                chartOfAccountPieChartOptions
                            );

                            chartOfAccountPieChart.render();
                        })
                    });
                </script>
            @endpush
        </div>
    </div>
</div>
