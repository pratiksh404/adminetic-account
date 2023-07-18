@extends(request()->header('layout') ?? (request()->header('layout') ?? 'adminetic::admin.layouts.app'))

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Ledgers</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> <i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Ledgers</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <x-adminetic-card title="All Ledger">
        <x-slot name="buttons">
            <a href="{{ adminCreateRoute('ledger') }}" class="btn btn-primary btn-air-primary router">Create Ledger</a>
        </x-slot>
        <x-slot name="content">
            {{-- ================================Card================================ --}}
            <table class="table table-striped table-bordered datatable">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Cr</th>
                        <th>Dr</th>
                        <th>Balance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ledgers as $ledger)
                        <tr>
                            <td>{{ $ledger->code }}</td>
                            <td>{{ $ledger->name }}</td>
                            <td class="text-success">{{ currency() . ($ledger->info['credit_total'] ?? 0) }}</td>
                            <td class="text-danger">{{ currency() . ($ledger->info['debit_total'] ?? 0) }}</td>
                            <td class="text-info">{{ currency() . ($ledger->info['balance'] ?? 0) }}</td>
                            <td>
                                <x-adminetic-action :model="$ledger" route="ledger" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Cr</th>
                        <th>Dr</th>
                        <th>Balance</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
            {{-- =================================================================== --}}
        </x-slot>
    </x-adminetic-card>
@endsection

@section('custom_js')
    @include('account::admin.layouts.modules.ledger.scripts')
@endsection
