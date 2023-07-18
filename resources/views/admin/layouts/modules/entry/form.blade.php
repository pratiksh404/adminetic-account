   <div class="row">
       @if (isset($entry))
           <small class="text-muted">Code : {{ $entry->code }}</small>
       @endif
       <div class="col-lg-4">
           <label for="ledger_id">
               {{ label('entries', 'ledger_id', 'Ledger') }}
           </label>
           <select name="ledger_id" id="ledger_id" class="select2 form-control">
               <option selected disabled>Select ...</option>
               @if ($ledgers->count() > 0)
                   @foreach ($ledgers as $ledger)
                       <option value="{{ $ledger->id }}"
                           {{ isset($entry) ? ($entry->ledger_id == $ledger->id ? 'selected' : '') : '' }}>
                           {{ $ledger->name }}</option>
                   @endforeach
               @endif
           </select>
       </div>
       <div class="col-lg-4">
           <label for="ledger_account">{{ label('entries', 'ledger_account', 'Ledger Account') }}</label>
           <select name="ledger_account" class="form-control">
               <option option="">Select ...</option>
               @if (count(ledger_accounts() ?? []) > 0)
                   @foreach (ledger_accounts() as $ledger_account)
                       <option value="{{ $ledger_account['name'] }}"
                           {{ isset($entry) ? ($entry->ledger_account == $ledger_account['name'] ? 'selected' : '') : '' }}>
                           {{ $ledger_account['name'] }}</option>
                       @if (count($ledger_account['children'] ?? []) > 0)
                           @foreach ($ledger_account['children'] as $ledger_account_children)
                               <option value="{{ $ledger_account_children['name'] }}"
                                   {{ isset($entry) ? ($entry->ledger_account == $ledger_account_children['name'] ? 'selected' : '') : '' }}>
                                   -> {{ $ledger_account_children['name'] }}</option>

                               @if (count($ledger_account_children['grand_children'] ?? []) > 0)
                                   @foreach ($ledger_account_children['grand_children'] as $ledger_account_grand_children)
                                       <option value="{{ $ledger_account_grand_children['name'] }}"
                                           {{ isset($entry) ? ($entry->ledger_account == $ledger_account_grand_children['name'] ? 'selected' : '') : '' }}>
                                           --> {{ $ledger_account_grand_children['name'] }}</option>
                                   @endforeach
                               @endif
                           @endforeach
                       @endif
                   @endforeach
               @endif
           </select>
       </div>
       <div class="col-lg-4">
           <div class="input-group">
               <span class="input-group-text">
                   <select name="account_type" class="form-control">
                       <option value="{{ DEBIT() }}"
                           {{ isset($entry) ? ($entry->account_type == DEBIT() ? 'selected' : '') : '' }}>Dr</option>
                       <option value="{{ CREDIT() }}"
                           {{ isset($entry) ? ($entry->account_type == CREDIT() ? 'selected' : '') : '' }}>Cr</option>
                   </select>
               </span>
               <span class="input-group-text">
                   {{ currency() }}
               </span>
               <input type="number" class="form-control" name="amount" value="{{ $entry->amount ?? old('amount') }}">
           </div>
       </div>
   </div>
   <br>
   <div class="row">
       <div class="col-12">
           <label for="journal_id">{{ label('entries', 'journal_id', 'Journal') }}</label>
           <select name="journal_id" id="journal_id" class="select2">
               <option selected disabled>Select Journal ...</option>
               @if ($journals->count() > 0)
                   @foreach ($journals as $journal)
                       <option value="{{ $journal->id }}"
                           {{ isset($entry) ? ($entry->journal_id == $journal->id ? 'selected' : '') : '' }}>
                           #{{ $journal->bill_no }}</option>
                   @endforeach
               @endif
           </select>
       </div>
   </div>
   <br>
   <div class="row">
       <div class="col-12">
           <label for="particular">{{ label('entries', 'particular') }}</label>
           <div class="input-group">
               <textarea name="particular" id="particular" cols="30" rows="10" class="form-control">{{ $entry->particular ?? old('particular') }}</textarea>
           </div>
       </div>
   </div>
   <br>
   <x-adminetic-edit-add-button :model="$entry ?? null" name="Entry" />
