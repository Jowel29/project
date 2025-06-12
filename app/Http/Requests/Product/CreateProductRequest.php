<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;

class CreateProductRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image',
            'price' => 'required|numeric|min:1',
        ];
    }
}
