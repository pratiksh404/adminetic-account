@extends(request()->header('layout') ?? (request()->header('layout') ?? 'adminetic::admin.layouts.app'))

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Journals</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> <i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Journals</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <x-adminetic-card title="All Journal">
        <x-slot name="buttons">
            <a href="{{ adminCreateRoute('journal') }}" class="btn btn-primary btn-air-primary router">Create Journal</a>
        </x-slot>
        <x-slot name="content">
            {{-- ================================Card================================ --}}
            <table class="table table-striped table-bordered datatable">
                <thead>
                    <tr>
                        <th>Bill No</th>
                        <th>Fiscal</th>
                        <th>Issued Date</th>
                        <th>Status</th>
                        <th>Approval</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($journals as $journal)
                        <tr>
                            <td>#{{ $journal->bill_no }}</td>
                            <td>{{ $journal->fiscal->name ?? '-' }}</td>
                            <td>{{ modeDate(\Carbon\Carbon::create($journal->issued_date)) }}</td>
                            <td>{{ $journal->status }}</td>
                            <td> @livewire('admin.journal.journal-approval', ['journal' => $journal], key($journal->id))</td>
                            <td>
                                <x-adminetic-action :model="$journal" route="journal" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Bill No</th>
                        <th>Fiscal</th>
                        <th>Issued Date</th>
                        <th>Status</th>
                        <th>Approval</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
            {{-- =================================================================== --}}
        </x-slot>
    </x-adminetic-card>
@endsection

@section('custom_js')
    @include('account::admin.layouts.modules.journal.scripts')
@endsection
