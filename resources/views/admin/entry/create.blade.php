@extends(request()->header('layout') ?? (request()->header('layout') ?? 'adminetic::admin.layouts.app'))

@section('content')
    <x-adminetic-create-page name="entry" route="entry">
        <x-slot name="content">
            {{-- ================================Form================================ --}}
            @include('account::admin.layouts.modules.entry.form')
            {{-- =================================================================== --}}
        </x-slot>
    </x-adminetic-create-page>
@endsection

@section('custom_js')
    @include('account::admin.layouts.modules.entry.scripts')
@endsection
