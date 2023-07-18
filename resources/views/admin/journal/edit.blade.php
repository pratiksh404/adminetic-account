@extends(request()->header('layout') ?? (request()->header('layout') ?? 'adminetic::admin.layouts.app'))

@section('content')
    <form action="{{ adminUpdateRoute('journal', $journal->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        @include('account::admin.layouts.modules.journal.form')
    </form>
@endsection

@section('custom_js')
    @include('account::admin.layouts.modules.journal.scripts')
@endsection
