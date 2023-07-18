<?php

namespace Adminetic\Account\Http\Requests;

use Adminetic\Account\Models\Admin\Account as Ac;
use Adminetic\Account\Rules\AmountTransactionRule;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'code' => $this->transaction->code ?? Str::uuid()->toString(),
            'issued_by' => Auth::user()->id,
            'issue_date' => $this->issue_date ?? (!is_null($this->transaction) ? $this->transaction->getRawOriginal('issue_date') ?? Carbon::now() : Carbon::now())
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $ac = Ac::find($this->account_id);
        $id = $this->transaction->id ?? '';
        return [
            'code' => 'required|max:255|unique:transactions,code,' . $id,
            'account_id' => 'required|exists:accounts,id',
            'amount' => ['required', 'numeric', new AmountTransactionRule($ac->balance(), $this->type)],
            'particular' => ' required|max:255',
            'remark' => 'nullable|max:5500',
            'type' => 'sometimes|numeric',
            'method' => 'nullable|numeric',
            'data' => 'nullable',
            'issue_date' => 'nullable',
            'issued_by' => 'required|exists:users,id',
            'verified_by' => 'nullable|exists:users,id',
            'status' => 'nullable|numeric',
        ];
    }
}
