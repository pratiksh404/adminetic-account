<div class="row">
    <div class="col-lg-6">
        <label for="name">{{ label('ledgers', 'name') }}</label>
        <div class="input-group">
            <input type="text" name="name" id="name" class="form-control"
                value="{{ $ledger->name ?? old('name') }}" placeholder="Ledger Name">
        </div>
    </div>
    <div class="col-lg-6">
        <label for="code">{{ label('ledgers', 'code') }}</label>
        <div class="input-group">
            <input type="text" name="code" id="code" class="form-control"
                value="{{ $ledger->code ?? old('code') }}" placeholder="Ledger Code">
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-12">
        <div class="input-group">
            <span class="input-group-text">{{ label('ledgers', 'opening_balance', 'Opening Balance') }}</span>
            <input type="number" name="opening_balance" id="opening_balance" step="any" class="form-control"
                value="{{ $ledger->opening_balance ?? old('opening_balance') }}">
        </div>
    </div>
</div>
<br>
<x-adminetic-edit-add-button :model="$ledger ?? null" name="Ledger" />
