<div class="row">
    <div class="col-lg-4">
        <label for="holder_name">{{ label('accounts', 'holder_name', 'Account Holder Name') }}</label>
        <input type="text" name="holder_name" id="holder_name" class="form-control"
            value="{{ $account->holder_name ?? old('holder_name') }}" placeholder="Account Holder Name">
    </div>
    <div class="col-lg-4">
        <label for="holder_email">{{ label('accounts', 'holder_email', 'Account Holder Email') }}</label>
        <input type="text" name="holder_email" id="holder_email" class="form-control"
            value="{{ $account->holder_email ?? old('holder_email') }}" placeholder="Account Holder Email">
    </div>
    <div class="col-lg-4">
        <label for="holder_phone">{{ label('accounts', 'holder_phone', 'Account Holder Phone') }}</label>
        <input type="text" name="holder_phone" id="holder_phone" class="form-control"
            value="{{ $account->holder_phone ?? old('holder_phone') }}" placeholder="Account Holder Phone">
    </div>
</div>
@if ($users->count() > 0)
    <br>
    <div class="row">
        <b>Link Users To This Account</b> <br>
        @foreach ($users->sortBy('name')->groupBy(fn($u) => substr($u->name, 0, 1)) as $alphabet => $group)
            <div class="col-lg-4 mt-4">
                <b>{{ $alphabet }} :-</b>
                <br>
                <ul>
                    @foreach ($group as $user)
                        <li><input type="checkbox" name="users[]" value="{{ $user->id }}"
                                {{ isset($account) ? ($user->account_id == $account->id ? 'checked' : '') : '' }}>{{ $user->name }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
@endif
<br>
<div class="row">
    <div class="col">
        <label for="description">{{ label('accounts', 'description') }}</label>
        <textarea name="description" id="heavytexteditor" cols="30" rows="10">
            @isset($account->description)
{!! $account->description !!}
@endisset
        </textarea>
    </div>
</div>
<br>
<x-adminetic-edit-add-button :model="$account ?? null" name="Account" />
