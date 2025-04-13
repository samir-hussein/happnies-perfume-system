<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes',
            'unit' => 'sometimes',
            "code" => "required",
            "description" => "sometimes",
            'qty' => 'required|numeric|min:0',
            'warning_qty' => 'sometimes|min:0',
            "price" => "required|numeric|min:0",
            "unit_price" => "required|numeric|min:0",
            "category_id" => "required|numeric|exists:categories,id",
            "discount" => "sometimes|min:0|max:100",
            "discount_type" => "sometimes|string|in:ratio,amount"
        ];
    }
}
