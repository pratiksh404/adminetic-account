<?php

namespace Adminetic\Account\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'no' => $this->no ?? $this->account->no ?? rand(1000000000, 9999999999),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id = $this->account->id ?? '';
        return [
            'no' => 'required|unique:' . config('account.table_prefix', 'account') . '_accounts' . ',no,' . $id,
            'holder_name' => 'required|max:255',
            'holder_email' => 'required|max:255',
            'holder_phone' => 'required|max:255',
            'active' => 'sometimes|boolean',
            'description' => 'nullable|max:5500',
            'type' => 'nullable|numeric'
        ];
    }
}
