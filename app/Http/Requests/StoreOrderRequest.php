<?php

namespace App\Http\Requests;

use App\Enums\PaymentChannel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
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
            'shipping' => 'required|numeric',
            'shipping_id' => ['required', Rule::exists('addresses', 'id')],
            'billing_id' => ['required', Rule::exists('addresses', 'id')],
            'product' => 'required|array',
            'product.*.name' => 'required|string|max:255',
            'product.*.price' => ['required', 'numeric'],
            'product.*.qty' => 'required|numeric',
            'product.*.product_id' => ['required', Rule::exists('products', 'id')],
            'channel' => ['nullable', Rule::enum(PaymentChannel::class)],
            'channel_detail' => 'nullable|array',
            'description' => 'nullable|string',
        ];
    }
}
