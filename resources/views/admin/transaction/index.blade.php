@extends(request()->header('layout') ?? (request()->header('layout') ?? 'adminetic::admin.layouts.app'))

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Transactions</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> <i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Transactions</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <x-adminetic-card title="All Transactions">
        <x-slot name="buttons">
            <a href="{{ adminCreateRoute('transaction') }}" class="btn btn-primary btn-air-primary router">Create
                Transaction</a>
        </x-slot>
        <x-slot name="content">
            {{-- ================================Card================================ --}}
            <table class="table table-striped table-bordered datatable">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Amount</th>
                        <th>Particular</th>
                        <th>Account</th>
                        <th>Issued Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->code }}</td>
                            <td><span
                                    class="text-{{ $transaction->getRawOriginal('type') == CREDIT() ? 'success' : ($transaction->getRawOriginal('type') == DEBIT() ? 'danger' : 'info') }}">{{ currency() . $transaction->amount }}
                                    .........
                                    {{ $transaction->getRawOriginal('type') == CREDIT() ? 'Cr' : ($transaction->getRawOriginal('type') == DEBIT() ? 'Dr' : '') }}</span>
                            </td>
                            <td>{!! $transaction->particular !!}</td>
                            <td>{{ $transaction->account->no }}</td>
                            <td>{{ modeDate(\Carbon\Carbon::create($transaction->issued_date)) }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <x-adminetic-action :model="$transaction" route="transaction" />
                                    @livewire('admin.transaction.transaction-approval', ['transaction' => $transaction], key('approval' . $transaction->id))
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
            {{-- =================================================================== --}}
        </x-slot>
    </x-adminetic-card>
@endsection

@section('custom_js')
    @include('account::admin.layouts.modules.transaction.scripts')
@endsection
