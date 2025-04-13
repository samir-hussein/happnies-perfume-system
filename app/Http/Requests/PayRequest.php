<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PayRequest extends FormRequest
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
            "client_name" => "sometimes",
            "phone" => "sometimes",
            "discount" => "sometimes|numeric|min:0|max:100",
            "discount_type" => "sometimes|in:ratio,amount",
            "employee" => "required|string|exists:employees,name",
            "data_invoice" => "required|array|min:1",
            "invoice_items" => "required|array|min:1",
            "type" => "required|string|in:online,offline",
            "status" => "required|string|in:finished,pendding",
            "delivery_price" => "sometimes|min:0",
            "delivery_place" => "sometimes",
            "delivery_date" => "sometimes",
            "note" => "sometimes",
            "gather_items" => "array",
        ];
    }
}
