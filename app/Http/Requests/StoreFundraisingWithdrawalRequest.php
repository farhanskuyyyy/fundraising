<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFundraisingWithdrawalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasAnyRole(['owner|fundraiser']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fundraising_id' => ['required','numeric','max:10'],
            'bank_name' => ['required','string','max:255'],
            'bank_account_name' => ['required','string','max:255'],
            'bank_account_number' => ['required','string','max:255'],
        ];
    }
}
