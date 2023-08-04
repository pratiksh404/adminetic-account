<?php

namespace Adminetic\Account\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JournalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'fiscal_id' => 'required|exists:' . config('account.table_prefix', 'account') . '_fiscals,id',
            'issued_date' => 'required',
            'status' => 'sometimes|numeric',
            'bill_no' => 'required',
            'data' => 'required',
            'remark' => 'nullable|max:5500',
            'approved_by' => 'nullable|exists:user,id'
        ];
    }
}
