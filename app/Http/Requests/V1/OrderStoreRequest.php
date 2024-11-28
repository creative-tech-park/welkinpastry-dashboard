<?php

namespace App\Http\Requests\V1;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'address_id' => 'required|exists:customer_addresses,id',
            'sub_total' => 'nullable|numeric',
            'grand_total' => 'nullable|numeric',
            'vat' => 'nullable|numeric',
            'pay_bill' => 'nullable|numeric',
            'pay_due' => 'nullable|numeric',
            'payment_method' => 'nullable|string|max:255',
            'order_type' => 'required|in:customer,pos',
            'payment_status' => 'required|in:paid,pending,cancelled',
            'order_date' => 'nullable',
            'order_id' => 'nullable',
            'order_items' => 'required|array'
        ];
    }
}