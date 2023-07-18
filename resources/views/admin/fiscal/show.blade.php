@extends(request()->header('layout') ?? (request()->header('layout') ?? 'adminetic::admin.layouts.app'))

@section('content')
    <x-adminetic-show-page name="fiscal" route="fiscal" :model="$fiscal">
        <x-slot name="content">

        </x-slot>
    </x-adminetic-show-page>
@endsection

@section('custom_js')
    @include('account::admin.layouts.modules.fiscal.scripts')
@endsection
