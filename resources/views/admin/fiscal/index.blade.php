@extends(request()->header('layout') ?? (request()->header('layout') ?? 'adminetic::admin.layouts.app'))

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Fiscals</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> <i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Fiscals</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <x-adminetic-card title="All Fiscal">
        <x-slot name="buttons">
            <a href="{{ adminCreateRoute('fiscal') }}" class="btn btn-primary btn-air-primary router">Create Entry</a>
        </x-slot>
        <x-slot name="content">
            {{-- ================================Card================================ --}}
            <table class="table table-striped table-bordered datatable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Interval</th>
                        <th>Active/Inactive</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fiscals as $fiscal)
                        <tr>
                            <td>{{ $fiscal->name }}</td>
                            <td>{{ modeDate(\Carbon\Carbon::create($fiscal->start_date)) . ' to ' . modeDate(\Carbon\Carbon::create($fiscal->end_date)) }}
                            </td>
                            <td>
                                <span
                                    class="badge badge-{{ $fiscal->active ? 'success' : 'danger' }}">{{ $fiscal->active ? 'Active' : 'Inactive' }}</span>
                            </td>
                            <td>
                                <x-adminetic-action :model="$fiscal" route="fiscal" />
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
    @include('account::admin.layouts.modules.fiscal.scripts')
@endsection
