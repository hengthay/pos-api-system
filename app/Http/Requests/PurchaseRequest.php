<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PurchaseRequest extends FormRequest
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
            "supplier_id" => "required|integer|exists:suppliers,id",
            "invoice_no" => "required|string|max:30",
            "total_amount" => "required|numeric|min:0",
            "purchase_date" => "required|date",
            "status" => "required|in:pending,received,cancelled",
        ];
    }
}
