<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
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
            "invoice_no" => "required|string|max:30|unique:sales,invoice_no",
            "customer_id" => "nullable|integer|exists:customers,id",
            "user_id" => "nullable|integer|exists:users,id",
            "subtotal" => "required|numeric|min:0|decimal:2",
            "discount" => "required|numeric|min:0",
            "tax" => "required|numeric|min:0|decimal:2",
            "total" => "required|numeric|min:0|decimal:2",
            "payment_status" => "required|in:unpaid,partial,paid,refunded",
            "sale_date" => "required|date"
        ];
    }
}
