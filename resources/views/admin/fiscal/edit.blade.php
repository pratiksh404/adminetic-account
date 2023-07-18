@extends(request()->header('layout') ?? (request()->header('layout') ?? 'adminetic::admin.layouts.app'))

@section('content')
    <x-adminetic-edit-page name="fiscal" route="fiscal" :model="$fiscal">
        <x-slot name="content">
            {{-- ================================Form================================ --}}
            @include('account::admin.layouts.modules.fiscal.form')
            {{-- =================================================================== --}}
        </x-slot>
    </x-adminetic-edit-page>
@endsection

@section('custom_js')
    @include('account::admin.layouts.modules.fiscal.scripts')
@endsection
