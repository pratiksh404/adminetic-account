@extends(request()->header('layout') ?? (request()->header('layout') ?? 'adminetic::admin.layouts.app'))

@section('content')
    <x-adminetic-show-page name="ledger" route="ledger" :model="$ledger">
        <x-slot name="content">
            @livewire('admin.ledger.ledger-profile', ['ledger' => $ledger])
        </x-slot>
    </x-adminetic-show-page>
@endsection

@section('custom_js')
    @include('account::admin.layouts.modules.ledger.scripts')
@endsection
