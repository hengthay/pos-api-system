<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "sale_id" => "required|integer|exists:sales,id",
            "payment_method" => "required|in:cash,card,qr,bank_transfer",
            "amount" => "required|numeric|min:0",
            "paid_at" => "required|date",
            "reference_no" => "nullable|string"
        ];
    }
}
