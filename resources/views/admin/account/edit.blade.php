@extends(request()->header('layout') ?? (request()->header('layout') ?? 'adminetic::admin.layouts.app'))

@section('content')
    <x-adminetic-edit-page name="account" route="account" :model="$account">
        <x-slot name="content">
            {{-- ================================Form================================ --}}
            @include('account::admin.layouts.modules.account.form')
            {{-- =================================================================== --}}
        </x-slot>
    </x-adminetic-edit-page>
@endsection

@section('custom_js')
    @include('account::admin.layouts.modules.account.scripts')
@endsection
