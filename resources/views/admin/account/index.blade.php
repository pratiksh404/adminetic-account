@extends(request()->header('layout') ?? (request()->header('layout') ?? 'adminetic::admin.layouts.app'))

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Accounts</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> <i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Accounts</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <x-adminetic-card title="All Account">
        <x-slot name="buttons">
            <a href="{{ adminCreateRoute('account') }}" class="btn btn-primary btn-air-primary router">Create Account</a>
        </x-slot>
        <x-slot name="content">
            {{-- ================================Card================================ --}}
            <table class="table table-striped table-bordered datatable">
                <thead>
                    <tr>
                        <th>Users</th>
                        <th>Account No</th>
                        <th>Holder Name</th>
                        <th>Holder Email</th>
                        <th>Holder Phone</th>
                        <th>Active</th>
                        <th>Balance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($accounts as $account)
                        <tr>
                            <td>
                                @if ($account->users->count() > 0)
                                    <div class="chat-time group-chat">
                                        <ul>
                                            @foreach ($account->users as $user)
                                                <li title="{{ $user->name }}"><img class="img-fluid rounded-circle"
                                                        width="40" src="{{ getProfilePlaceholder($user->profile) }}"
                                                        alt="{{ $user->name }}"></li>
                                            @endforeach
                                    </div>
                                @endif
                            </td>
                            <td>{{ $account->no }}</td>
                            <td>{{ $account->holder_name }}</td>
                            <td>{{ $account->holder_email }}</td>
                            <td>{{ $account->holder_phone }}</td>
                            <td>{{ $account->active ? 'Active' : 'Unactive' }}</td>
                            <td>{{ currency() . $account->balance() }}</td>
                            <td>
                                <x-adminetic-action :model="$account" route="account" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Users</th>
                        <th>Account No</th>
                        <th>Holder Name</th>
                        <th>Holder Email</th>
                        <th>Holder Phone</th>
                        <th>Active</th>
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
    @include('account::admin.layouts.modules.account.scripts')
@endsection
