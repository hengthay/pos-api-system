<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            "product_name" => "required|string|max:100",
            "product_code" => [
                                "required",
                                "string",
                                "max:40",
                                Rule::unique("products", "product_code")->ignore($this->route("product")),
                            ],
            "brand" => "nullable|string|max:100",
            "cost_price" => "required|numeric|min:0",
            "selling_price" => "required|numeric|min:0",
            "stock_quantity" => "required|integer",
            "image_url" => "nullable|image|mimes:jpg,jpeg,png,svg|max:2048",
            "description" => "nullable|string",
            "category_id" => "required|integer|exists:categories,id"
        ];
    }
}
