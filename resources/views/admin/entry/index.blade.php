@extends(request()->header('layout') ?? (request()->header('layout') ?? 'adminetic::admin.layouts.app'))

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Entries</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> <i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Entries</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <x-adminetic-card title="All Entry">
        <x-slot name="buttons">
            <a href="{{ adminCreateRoute('entry') }}" class="btn btn-primary btn-air-primary router">Create Entry</a>
        </x-slot>
        <x-slot name="content">
            {{-- ================================Card================================ --}}
            <table class="table table-striped table-bordered datatable">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Ledger</th>
                        <th>Journal</th>
                        <th>Amount</th>
                        <th>Particular</th>
                        <th>Issued By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entries as $entry)
                        <tr>
                            <td>{{ $entry->code }}</td>
                            <td>
                                {{ $entry->ledger->name }}
                                -> {{ $entry->ledger_account }}
                            </td>
                            <td>
                                {{ $entry->journal_id }}
                            </td>
                            <td>{{ currency() . $entry->amount }} .........
                                {{ $entry->getRawOriginal('account_type') == CREDIT() ? 'Cr' : ($entry->getRawOriginal('account_type') == DEBIT() ? 'Dr' : '') }}
                            </td>
                            <td>
                                {!! $entry->particular !!}
                            </td>
                            <td>{{ $entry->issuedBy->name ?? '-' }}</td>
                            <td class="d-flex justify-content-center">
                                <x-adminetic-action :model="$entry" route="entry" />
                                @livewire('admin.entry.entry-transform-to-transaction', ['entry' => $entry], key($entry->id))
                                @livewire('admin.entry.entry-approval', ['entry' => $entry], key('approval' . $entry->id))
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Code</th>
                        <th>Ledger</th>
                        <th>Journal</th>
                        <th>Amount</th>
                        <th>Particular</th>
                        <th>Issued By</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
            {{-- =================================================================== --}}
        </x-slot>
    </x-adminetic-card>
@endsection

@section('custom_js')
    @include('account::admin.layouts.modules.entry.scripts')
@endsection
