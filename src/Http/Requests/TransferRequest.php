<?php

namespace Adminetic\Account\Http\Requests;

use Adminetic\Account\Models\Admin\Account as Ac;
use Adminetic\Account\Models\Admin\Transaction;
use Adminetic\Account\Rules\AmountTransactionRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
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
            'issued_by' => Auth::user()->id,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $ac = Ac::find($this->account_from);
        $id = $this->transfer->id ?? '';
        return [
            'account_from' => 'required|exists:accounts,id',
            'account_to' => 'required|exists:accounts,id',
            'amount' => ['required', 'numeric', new AmountTransactionRule($ac->balance(), Transaction::WITHDRAW)],
            'remark' => 'nullable|max:5500',
            'particular' => 'nullable|max:5500',
            'issued_by' => 'required|exists:users,id'
        ];
    }
}
