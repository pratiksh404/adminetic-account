<?php

namespace Adminetic\Account\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EntryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'code' => $this->code ?? entry_code($this->ledger_id, $this->journal_id),
            'issued_by' => Auth::user()->id
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id = $this->entry->id ?? '';
        return [
            'code' => 'required|unique:' . config('account.table_prefix', 'account') . '_entries' . ',code,' . $id,
            'ledger_id' => 'required|exists:' . config('account.table_prefix', 'account') . '_ledgers' . ',id',
            'ledger_account' => 'required',
            'journal_id' => 'required|exists:' . config('account.table_prefix', 'account') . '_journals' . ',id',
            'account_type' => 'required|numeric',
            'amount' => 'required|numeric',
            'particular' => 'nullable|max:5500',
            'issued_by' => 'required|exists:users,id',
            'approved_by' => 'nullable|exists:users,id',
            'data' => 'nullable'
        ];
    }
}
