<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SaleItemRequest extends FormRequest
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
            "product_id" => "nullable|integer|exists:products,id",
            "quantity" => "required|integer",
            "unit_price" => "required|numeric|min:0",
            "discount" => "required|numeric|min:0",
        ];
    }
}
