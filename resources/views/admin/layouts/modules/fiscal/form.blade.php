<div class="row">
    <div class="col-lg-6">
        <label for="name">{{ label('fiscals', 'name') }}</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $fiscal->name ?? old('name') }}"
            placeholder="{{ \Carbon\Carbon::now()->year . ' / ' . toDetailBS(\Carbon\Carbon::now())->year }}">
    </div>
    <div class="col-lg-6">
        <label for="interval">{{ label('fiscals', 'interval') }}</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
            <input type="hidden" name="start_date" id="start_date" value="{{ $fiscal->start_date ?? null }}">
            <input type="hidden" name="end_date" id="end_date" value="{{ $fiscal->end_date ?? null }}">
            <input type="text" name="interval" id="interval" class="form-control"
                value="{{ $fiscal->interval ?? old('interval') }}">
        </div>
    </div>
</div>
<x-adminetic-edit-add-button :model="$fiscal ?? null" name="Fiscal" />
