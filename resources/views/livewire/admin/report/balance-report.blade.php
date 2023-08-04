<div>
    <div class="input-group">
        <span class="input-group-text"><i class="fa fa-clock"></i></span>
        <input type="text" id="interval" class="form-control">
    </div>
    <div class="card mt-3">
        <div class="card-body shadow-lg p-3" style="height: 75vh;overflow-y:auto">
            @if (!is_null($entries))
                @if ($entries->count() > 0)
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
                                    <h4 class="text-center">Balance Report</h4>
                                </td>
                            </tr>
                            @if (!is_null($start_date) && !is_null($end_date))
                                <tr>
                                    <td>
                                        <h4 class="text-center">{{ $start_date->toDateString() }} to
                                            {{ $end_date->toDateString() }}</h4>
                                    </td>
                                </tr>
                            @endif
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
                                                @php
                                                    $balance = $entries->first()->balance();
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
                                                                title="{{ !is_null($entry->approved_by) ? 'Approved By : ' . $entry->approvedBy->name : 'Not Approved' }}"
                                                                style="min-width: 7px;height: 7px;border: 4px solid {{ !is_null($entry->approved_by) ? '#33cc33' : '#cc0000' }};background: #fff;border-radius: 100%;display: inline-block;"></span>
                                                            <span>#{{ $entry->code }}</span>
                                                        </td>
                                                        <td style="padding: 10px 15px;">
                                                            <span>{{ modeDate(\Carbon\Carbon::create($entry->created_at)) }}</span>
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
                                                            {{ ($balance < 0 ? 'Dr.' : 'Cr.') . currency() . abs($balance) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr>
                                                <td rowspan="5">
                                                    <div class="mt-3" id="entry-sparklines-chart"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> </td>
                                                <td> </td>
                                                <td style="padding: 5px 0; padding-top: 15px;">
                                                    <span style="color: #52526C;">Credit</span>
                                                </td>
                                                <td style="padding: 5px 0;text-align: right;padding-top: 15px;">
                                                    <span>{{ currency() . $entries->filter(fn($e) => $e->account_type == CREDIT())->sum('amount') }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> </td>
                                                <td> </td>
                                                <td style="padding: 5px 0;padding-top: 0;">
                                                    <span style="color: #52526C;">Debit</span>
                                                </td>
                                                <td style="padding: 5px 0;text-align: right;padding-top: 0;">
                                                    <span>{{ currency() . $entries->filter(fn($e) => $e->account_type == DEBIT())->sum('amount') }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> </td>
                                                <td> </td>
                                                <td style="padding: 10px 0;"> <span style="font-weight: 600;">Opening
                                                        Balance</span>
                                                </td>
                                                <td style="padding: 10px 0;text-align: right">
                                                    <span
                                                        style="font-weight: 600;">{{ currency() . ($entries->first()->account_type == CREDIT() ? $entries->first()->balance() - $entries->first()->amount : $entries->first()->balance() + $entries->first()->amount) }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> </td>
                                                <td> </td>
                                                <td style="padding: 10px 0;"> <span style="font-weight: 600;">Closing
                                                        Balance</span>
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
                    <div class="d-flex justify-content-end">
                        <span style="display: flex; justify-content: end; gap: 15px;"><button type="button"
                                style="background: rgba(115, 102, 255, 1); color:rgba(255, 255, 255, 1);border-radius: 10px;padding: 18px 27px;font-size: 16px;font-weight: 600;outline: 0;border: 0; text-decoration: none;"
                                wire:click="print">Print<i class="icon-arrow-right"
                                    style="font-size:13px;font-weight:bold; margin-left: 10px;"></i></button><button
                                type="button"
                                style="background: rgba(115, 102, 255, 0.1);color: rgba(115, 102, 255, 1);border-radius: 10px;padding: 18px 27px;font-size: 16px;font-weight: 600;outline: 0;border: 0; text-decoration: none;"
                                wire:click="download">Download<i class="icon-arrow-right"
                                    style="font-size:13px;font-weight:bold; margin-left: 10px;"></i></button></span>
                    </div>
                @else
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('adminetic/static/not_found.gif') }}" alt="No entry Found"
                            class="img-fluid">
                    </div>
                @endif
            @else
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('adminetic/static/onloading.gif') }}" alt="No entry" class="img-fluid">
                </div>
            @endif
        </div>
    </div>
    @push('livewire_third_party')
        <script>
            $(function() {
                Livewire.emit('initialize_balance_report');
                Livewire.on('initializeBalanceReport', function() {
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
                Livewire.on('print_report', function() {
                    $('#journal').printThis();
                });
                Livewire.on('download_report', function() {
                    html2canvas(document.querySelector('#journal')).then(function(canvas) {
                        var anchorTag = document.createElement("a");
                        document.body.appendChild(anchorTag);
                        anchorTag.download = "receipt.jpg";
                        anchorTag.href = canvas.toDataURL();
                        anchorTag.target = '_blank';
                        anchorTag.click();
                    });
                });

                window.addEventListener('entry_sparklines_chart', event => {
                    $('#entry-sparklines-chart').empty();
                    var entrySparklinesChartOptions = {
                        series: [{
                            data: event.detail
                        }],
                        chart: {
                            type: 'area',
                            height: 160,
                            sparkline: {
                                enabled: true
                            },
                        },
                        stroke: {
                            curve: 'straight'
                        },
                        fill: {
                            opacity: 0.3
                        },
                        xaxis: {
                            crosshairs: {
                                width: 1
                            },
                        },
                        yaxis: {
                            min: 0
                        },
                        title: {
                            text: '{{ currency() }}' + event.detail.at(-1),
                            offsetX: 0,
                            style: {
                                fontSize: '24px',
                            }
                        },
                        subtitle: {
                            text: 'Balance',
                            offsetX: 0,
                            style: {
                                fontSize: '14px',
                            }
                        }
                    };

                    var entrySparklinesChart = new ApexCharts(document.querySelector(
                            "#entry-sparklines-chart"),
                        entrySparklinesChartOptions);
                    entrySparklinesChart.render();
                });
            });
        </script>
    @endpush
</div>
