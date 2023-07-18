@extends(request()->header('layout') ?? (request()->header('layout') ?? 'adminetic::admin.layouts.app'))

@section('content')
    <x-adminetic-show-page name="entry" route="entry" :model="$entry">
        <x-slot name="content">

        </x-slot>
    </x-adminetic-show-page>
@endsection

@section('custom_js')
    @include('account::admin.layouts.modules.entry.scripts')
@endsection
