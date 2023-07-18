@extends(request()->header('layout') ?? (request()->header('layout') ?? 'adminetic::admin.layouts.app'))

@section('content')
    <x-adminetic-show-page name="account" route="account" :model="$account">
        <x-slot name="content">

        </x-slot>
    </x-adminetic-show-page>
@endsection

@section('custom_js')
    @include('account::admin.layouts.modules.account.scripts')
@endsection
