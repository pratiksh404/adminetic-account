@extends(request()->header('layout') ?? (request()->header('layout') ?? 'adminetic::admin.layouts.app'))

@section('content')
    <form action="{{ adminStoreRoute('journal') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('account::admin.layouts.modules.journal.form')
    </form>
@endsection

@section('custom_js')
    @include('account::admin.layouts.modules.journal.scripts')
@endsection
