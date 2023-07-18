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
                <div class="card-header bg-primary">
                    <div class="d-flex justify-content-between">
                        Balance
                    </div>
                </div>
                <div class="card-body shadow-lg" style="height: 550px;overflow-y:auto">
                    @if (!is_null($date_wise_cumulative_balances))
                        <div class="table-responsive recent-table transaction-table">
                            <table class="table">
                                <tbody>
                                    @if (count($date_wise_cumulative_balances ?? []) > 0)
                                        @foreach ($date_wise_cumulative_balances as $date => $balance)
                                            <tr>
                                                <td>
                                                    <div class="d-flex">
                                                        <div>
                                                            <h6 class="f-14 mb-0">{{ $date }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td> <span class="f-light f-w-500">{{ currency() . $balance }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body shadow-lg">
                    <div id="datewise-cumulative-balance-report-area-chart"></div>
                </div>
            </div>
        </div>
    </div>
    <br>
    @if (!is_null($entries))
        @if ($entries->count() > 0)
            <div class="card">
                <div class="card-body shadow-lg" style="height: 40vh;overflow-y:auto">
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
                                                <th style="padding: 10px 15px;text-align: left">
                                                    <span style="color: #fff;">Transaction
                                                        Date</span>
                                                </th>
                                                <th style="padding: 10px 15px;text-align: left">
                                                    <span style="color: #fff;">Remark</span>
                                                </th>
                                                <th style="padding: 10px 15px;text-align: center">
                                                    <span style="color: #fff;">Credit
                                                        (Cr.)</span>
                                                </th>
                                                <th style="padding: 10px 15px;text-align: center">
                                                    <span style="color: #fff;">Debit
                                                        (Dr.)</span>
                                                </th>
                                                <th style="padding: 10px 15px;text-align: center">
                                                    <span style="color: #fff;">Balance</span>
                                                </th>
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
                                                            <span>{{ modeDate(\Carbon\Carbon::create($entry->journal->issued_date)) }}</span>
                                                        </td>
                                                        <td style="padding: 10px 15px;">
                                                            <span>{!! $entry->particular !!}</span>
                                                        </td>
                                                        <td style="padding: 10px 15px;text-align:center">
                                                            <span>{{ $entry->account_type == CREDIT() ? currency() . $entry->amount : '-' }}</span>
                                                        </td>
                                                        <td style="padding: 10px 15px;text-align:center">
                                                            <span>{{ $entry->account_type == DEBIT() ? currency() . $entry->amount : '-' }}</span>
                                                        </td>
                                                        <td style="padding: 10px 15px;text-align:center">
                                                            {{ currency() . $entry->balance() }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr>
                                                <td> </td>
                                                <td> </td>
                                                <td style="padding: 10px 0;"> <span
                                                        style="font-weight: 600;">Balance</span>
                                                </td>
                                                <td style="padding: 10px 0;text-align: right">
                                                    <span
                                                        style="font-weight: 600;">{{ currency() . $entry->balance() }}</span>
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
        @endif
    @endif
    @push('livewire_third_party')
        <script>
            $(function() {
                Livewire.emit('initialize_cumulative_balance_report');
                Livewire.on('initializeCumulativeBalanceReport', function() {
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
                window.addEventListener('datewise_cumulative_balance_report', event => {
                    $('#datewise-cumulative-balance-report-area-chart').empty();
                    var date = [];
                    var balance = [];
                    var data = event.detail;
                    Object.keys(data).forEach(function(d) {
                        date.push(d);
                        balance.push(data[d]);
                    });
                    var datewiseCumulativeBalanceReportAreaChartOptions = {
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
                        colors: [CubaAdminConfig.primary]
                    }

                    var datewiseCumulativeBalanceReportAreaChart = new ApexCharts(
                        document.querySelector("#datewise-cumulative-balance-report-area-chart"),
                        datewiseCumulativeBalanceReportAreaChartOptions
                    );

                    datewiseCumulativeBalanceReportAreaChart.render();
                })
            });
        </script>
    @endpush
</div>
