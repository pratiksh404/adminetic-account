    <style>
        table {
            border: none
        }

        table tr,
        th,
        td {
            border: none
        }

        .receipt {
            margin: 40px;
            border: 4px solid black;
            border-radius: 20px;
        }

        header {
            padding: 15px;
        }

        .school-info {
            margin-top: 5px;
            float: right;
            font-size: 18px;
            font-weight: lighter;
        }

        .receipt-sub-header {
            margin: 20px;
        }

        .receipt-no {
            float: left;
        }

        .receipt-title {
            text-align: center;
            border: 2px solid black;
            border-radius: 20px;
            background-color: black;
            color: white;
            padding: 4px;
        }

        .receipt-date {
            float: right;
        }

        .content {
            margin: 20px;
            padding: 15px;
        }

        .receipt-value {
            border-bottom: 1px dotted black;
            text-decoration: none;
        }

        .signature {
            margin-top: 80px;
            border-top: 1px dotted black;
            text-decoration: none;
            font-weight: bolder;
            float: right;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            .a4 {
                height: 29.718cm;
                width: 21.082cm;
                page-break-after: auto;
            }

            .receipt {
                margin: 0.2cm;
                height: 14cm;
            }

            header {
                padding: 0px;
            }

            .school-info {
                font-size: 10px;
            }

            header img {
                width: 4cm;
                height: auto;
            }

            .receipt-sub-header {
                margin: 0px;
            }

            .content {
                margin: 0px;
            }

            .signature {
                margin-top: 2px;
            }

            .receipt-sub-header {
                margin: 5px;
            }

            footer {
                margin-top: 2cm;
            }
        }
    </style>
    <div class="a4">
        {{-- Payer Receipt --}}
        <div class="receipt">
            <header>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-borderless">
                            <tr>
                                <td>
                                    <img src="{{ logo() }}" width="200" />
                                </td>
                                <td class="school-info">
                                    <span class="text-muted">Tel:
                                        {{ !is_null(company_email()) ? implode(',', company_email()) : company_phone() }}</span><br />
                                    <span class="text-muted">Email:
                                        {{ !is_null(company_phone()) ? implode(',', company_phone()) : company_email() }}</span><br />
                                    <span class="text-muted">Website: {{ url('/') }}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </header>
            <div class="receipt-sub-header">
                <table class="table table-borderless">
                    <tr>
                        <td style="width: 33.33%">
                            <div class="receipt-no">
                                <b>Receipt No.</b>
                                <span class="text-danger">{{ $transaction->id }}</span>
                            </div>
                        </td>
                        <td style="width: 33.33%">
                            <div class="receipt-title">
                                <b style="text-align: center">Receipt</b>
                            </div>
                        </td>
                        <td style="width: 33.33%">
                            <div class="receipt-date">
                                <b>Date</b>
                                {{ $transaction->created_at->toDateString() }}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- Content -->
            <div class="content">
                <div class="d-flex justify-content-start">
                    <b>Received with thanks from Mr/Miss : </b>
                    <span class="receipt-value">
                        {{ $transaction->contact['name'] ?? '' }}</span>
                </div>
                <br />
                <div class="d-flex justify-content-start">
                    <div>
                        <b>For the propose : </b>
                        <span class="receipt-value">{{ $transaction->particular }}</span>
                    </div>
                </div>
                <br />
                <div class="d-flex justify-content-start">
                    <div>
                        <b>a sum of Rs. in figure </b>
                        <span class="receipt-value"> {{ currency() . ($transaction->amount ?? 'N/A') }} /- </span>
                    </div>
                    <div>
                        <b>In words : </b>
                        <span class="receipt-value">
                            {{ currency() . \Illuminate\Support\Str::ucfirst($transaction->transaction_in_word ?? 'N/A') }}
                            only.</span>
                    </div>
                </div>
                <br><br>
                <footer>
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-center">
                                {{-- {!! QrCode::size(100)->generate(adminShowRoute('transaction', $transaction->id)) !!} --}}
                            </td>
                            <td><b>
                                    <div class="d-flex justify-content-center">
                                        <span class="text-muted">Customers's Copy</span>
                                    </div>
                                </b></td>
                            <td>
                                <div class="signature">
                                    for {{ title() }}
                                </div>
                            </td>
                        </tr>
                    </table>
                </footer>
            </div>
        </div>
        {{-- Admin Receipt --}}
        <div class="receipt">
            <header>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-borderless">
                            <tr>
                                <td>
                                    <img src="{{ logo() }}" width="200" />
                                </td>
                                <td class="school-info">
                                    <span class="text-muted">Tel:
                                        {{ !is_null(company_email()) ? implode(',', company_email()) : company_phone() }}</span><br />
                                    <span class="text-muted">Email:
                                        {{ !is_null(company_phone()) ? implode(',', company_phone()) : company_email() }}</span><br />
                                    <span class="text-muted">Website: {{ url('/') }}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </header>
            <div class="receipt-sub-header">
                <table class="table table-borderless">
                    <tr>
                        <td style="width: 33.33%">
                            <div class="receipt-no">
                                <b>Receipt No.</b>
                                <span class="text-danger">{{ $transaction->id }}</span>
                            </div>
                        </td>
                        <td style="width: 33.33%">
                            <div class="receipt-title">
                                <b style="text-align: center">Receipt</b>
                            </div>
                        </td>
                        <td style="width: 33.33%">
                            <div class="receipt-date">
                                <b>Date</b>
                                {{ $transaction->created_at->toDateString() }}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- Content -->
            <div class="content">
                <div class="d-flex justify-content-start">
                    <b>Received with thanks from Mr/Miss : </b>
                    <span class="receipt-value">
                        {{ $transaction->contact['name'] ?? '' }}</span>
                </div>
                <br />
                <div class="d-flex justify-content-start">
                    <div>
                        <b>For the propose : </b>
                        <span class="receipt-value">{{ $transaction->particular }}</span>
                    </div>
                </div>
                <br />
                <div class="d-flex justify-content-start">
                    <div>
                        <b>a sum of Rs. in figure </b>
                        <span class="receipt-value"> {{ currency() . ($transaction->amount ?? 'N/A') }} /- </span>
                    </div>
                    <div>
                        <b>In words : </b>
                        <span class="receipt-value">
                            {{ currency() . \Illuminate\Support\Str::ucfirst($transaction->transaction_in_word ?? 'N/A') }}
                            only.</span>
                    </div>
                </div>
                <br><br>
                <footer>
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-center">
                                {{-- {!! QrCode::size(100)->generate(adminShowRoute('transaction', $transaction->id)) !!} --}}
                            </td>
                            <td><b>
                                    <div class="d-flex justify-content-center">
                                        <span class="text-muted">Administration's Copy</span>
                                    </div>
                                </b></td>
                            <td>
                                <div class="signature">
                                    for {{ title() }}
                                </div>
                            </td>
                        </tr>
                    </table>
                </footer>
            </div>
        </div>
    </div>
