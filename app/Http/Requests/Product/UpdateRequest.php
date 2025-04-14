<?php

namespace App\Http\Requests\Product;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|string',
            'unit' => 'required|string',
            "code" => "required|unique:products,code," . request("product")->id,
            "description" => "sometimes",
            'qty' => 'sometimes|numeric',
            'warning_qty' => 'sometimes|min:0',
            "price" => "required|numeric|min:0",
            "unit_price" => "sometimes|min:0",
            "category_id" => "required|numeric|exists:categories,id",
            "discount" => "sometimes|min:0|max:100",
            "discount_type" => "sometimes|string|in:ratio,amount"
        ];
    }
}
