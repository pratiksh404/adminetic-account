<div>
    <div class="text-center">Statistics from {{ modeDate($start_date) . ' to ' . modeDate($end_date) }}</div>
    <br>
    <div class="input-group">
        <span class="input-group-text"><i class="fa fa-clock"></i></span>
        <input type="text" class="form-control" id="interval">
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body shadow-lg bg-success">
                    Profit
                    <br>
                    <h3>{{ currency() . \Adminetic\Account\Models\Admin\Entry::where('account_type', CREDIT())->sum('amount') }}
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body shadow-lg bg-primary">
                    Balance
                    <br>
                    <h3>{{ currency() . (\Adminetic\Account\Models\Admin\Entry::where('account_type', CREDIT())->sum('amount') - \Adminetic\Account\Models\Admin\Entry::where('account_type', DEBIT())->sum('amount')) }}
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body shadow-lg bg-danger">
                    Loss
                    <br>
                    <h3>{{ currency() . \Adminetic\Account\Models\Admin\Entry::where('account_type', DEBIT())->sum('amount') }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header bg-success">
                    <div class="d-flex justify-content-between">
                        Profit
                        <b>{{ currency() . (!is_null($profits) ? $profits->sum('amount') : 0) }}</b>
                    </div>
                </div>
                <div class="card-body shadow-lg" style="height: 550px;overflow-y:auto">
                    @if (!is_null($profits))
                        <div class="table-responsive recent-table transaction-table">
                            <table class="table">
                                <tbody>
                                    @foreach ($profits as $profit)
                                        <tr>
                                            <td>
                                                <div class="d-flex"> <svg xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="feather feather-trending-up font-success me-2">
                                                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                                        <polyline points="17 6 23 6 23 12"></polyline>
                                                    </svg>
                                                    <div>
                                                        <h6 class="f-14 mb-0">{{ $profit->ledger_account }}</h6><span
                                                            class="f-light">{{ modeDate(\Carbon\Carbon::create($profit->created_at)) }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td> <span class="f-light f-w-500">{{ $profit->issuedBy->name }}</span></td>
                                            <td> <span class="f-light f-w-500">{{ currency() . $profit->amount }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body shadow-lg">
                    <div id="profit-loss-area-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header bg-danger">
                    <div class="d-flex justify-content-between">
                        Loss
                        <b>{{ currency() . (!is_null($losses) ? $losses->sum('amount') : 0) }}</b>
                    </div>
                </div>
                <div class="card-body shadow-lg" style="height: 550px;overflow-y:auto">
                    @if (!is_null($losses))
                        <div class="table-responsive recent-table transaction-table">
                            <table class="table">
                                <tbody>
                                    @foreach ($losses as $loss)
                                        <tr>
                                            <td>
                                                <div class="d-flex"><svg xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="feather feather-trending-down font-danger me-2">
                                                        <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                        <polyline points="17 18 23 18 23 12"></polyline>
                                                    </svg>
                                                    <div>
                                                        <h6 class="f-14 mb-0">{{ $loss->ledger_account }}</h6><span
                                                            class="f-light">{{ modeDate(\Carbon\Carbon::create($loss->created_at)) }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td> <span class="f-light f-w-500">{{ $loss->issuedBy->name }}</span></td>
                                            <td> <span class="f-light f-w-500">{{ currency() . $loss->amount }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if (count($profit_loss_balance ?? []) > 0)
        <div class="card">
            <div class="card-body shadow-lg" style="height: 40vh;overflow-y:auto">
                <table class="table-wrapper" style="width:100%" id="journal">
                    <tbody>
                        <tr>
                            <td>
                                <table class="order-details"
                                    style="width: 100%;border-collapse: separate;border-spacing: 0 10px;">
                                    <thead>
                                        <tr
                                            style="background: #7366FF;border-radius: 8px;overflow: hidden;box-shadow: 0px 10.9412px 10.9412px rgba(82, 77, 141, 0.04), 0px 9.51387px 7.6111px rgba(82, 77, 141, 0.06), 0px 5.05275px 4.0422px rgba(82, 77, 141, 0.0484671);border-radius: 5.47059px;">
                                            <th
                                                style="padding: 10px 15px;border-top-left-radius: 8px;border-bottom-left-radius: 8px;text-align: left">
                                                <span style="color: #fff;">Date</span>
                                            </th>
                                            <th style="padding: 10px 15px;text-align: center">
                                                <span style="color: #fff;">Status</span>
                                            </th>
                                            <th style="padding: 10px 15px;text-align: center">
                                                <span style="color: #fff;">Profit</span>
                                            </th>
                                            <th style="padding: 10px 15px;text-align: center">
                                                <span style="color: #fff;">Loss</span>
                                            </th>
                                            <th style="padding: 10px 15px;text-align: center">
                                                <span style="color: #fff;">Balance</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($profit_loss_balance as $date => $plb)
                                            <tr
                                                style="box-shadow: 0px 10.9412px 10.9412px rgba(82, 77, 141, 0.04), 0px 9.51387px 7.6111px rgba(82, 77, 141, 0.06), 0px 5.05275px 4.0422px rgba(82, 77, 141, 0.0484671);border-radius: 5.47059px;">
                                                <td
                                                    style="padding: 10px 15px;display:flex;align-items: center;gap: 10px;">
                                                    <span>{{ $date }}</span>
                                                </td>
                                                <td style="padding: 10px 15px;text-align:center">
                                                    <span>
                                                        <i
                                                            class="  {{ $plb['balance'] > 0 ? 'fa fa-arrow-up text-success' : ($plb['balance'] < 0 ? 'fa fa-arrow-down text-danger' : 'fa fa-equals text-info') }}"></i>
                                                    </span>
                                                </td>
                                                <td style="padding: 10px 15px;text-align:center">
                                                    <span>{{ currency() . $plb['profit'] }}</span>
                                                </td>
                                                <td style="padding: 10px 15px;text-align:center">
                                                    <span>{{ currency() . $plb['loss'] }}</span>
                                                </td>
                                                <td style="padding: 10px 15px;text-align:center">
                                                    <span>{{ currency() . $plb['balance'] }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    @push('livewire_third_party')
        <script>
            $(function() {
                Livewire.emit('initialize_profit_loss_report');
                Livewire.on('initializeProfitLossReport', function() {
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
                window.addEventListener('profit_loss_report', event => {
                    $('#profit-loss-area-chart').empty();
                    var date = [];
                    var profit = [];
                    var loss = [];
                    var balance = [];
                    var data = event.detail;
                    Object.keys(data).forEach(function(d) {
                        date.push(d);
                        profit.push(data[d]['profit']);
                        loss.push(data[d]['loss']);
                        balance.push(data[d]['balance']);
                    });
                    var profitLossAreaChartOptions = {
                        chart: {
                            height: 550,
                            type: 'area',
                            toolbar: {
                                show: false
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth'
                        },
                        series: [{
                            name: 'Profit',
                            data: profit
                        }, {
                            name: 'Loss',
                            data: loss
                        }, {
                            name: 'Balance',
                            data: balance
                        }],

                        xaxis: {
                            categories: date
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return '{{ currency() }}' + val
                                }
                            }
                        },
                        colors: ['#009900', '#cc0000', CubaAdminConfig.primary]
                    }

                    var profitLossAreaChart = new ApexCharts(
                        document.querySelector("#profit-loss-area-chart"),
                        profitLossAreaChartOptions
                    );

                    profitLossAreaChart.render();
                })
            });
        </script>
    @endpush
</div>
