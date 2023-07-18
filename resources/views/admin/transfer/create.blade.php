@extends(request()->header('layout') ?? (request()->header('layout') ?? 'adminetic::admin.layouts.app'))

@section('content')
    <x-adminetic-create-page name="transfer" route="transfer">
        <x-slot name="content">
            {{-- ================================Form================================ --}}
            @include('account::admin.layouts.modules.transfer.form')
            {{-- =================================================================== --}}
        </x-slot>
    </x-adminetic-create-page>
@endsection

@section('custom_js')
    @include('account::admin.layouts.modules.transfer.scripts')
@endsection
