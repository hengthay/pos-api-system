<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
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
            "name" => "required|string|max:100",
            "discount_type" => "required|in:percent,fixed",
            "value" => "required|numeric|min:0",
            "start_date" => "nullable|date",
            "end_date" => "nullable|date|after_or_equal:start_date",
            "is_active" => "required|boolean"
        ];
    }
}
