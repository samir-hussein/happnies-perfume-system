<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WholesalePayRequest extends FormRequest
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
            "data_invoice" => "required|array|min:1",
            "invoice_items" => "required|array|min:1",
            "type" => "required|string|in:online,offline",
            "status" => "required|string|in:finished,pendding",
        ];
    }
}
