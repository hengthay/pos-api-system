<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PurchaseItemRequest extends FormRequest
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
            "purchase_id" => "required|integer|exists:purchases,id",
            "product_id" => "required|integer|exists:products,id",
            "quantity" => "required|integer",
            "cost_price" => "required|numeric|min:0",
        ];
    }
}
