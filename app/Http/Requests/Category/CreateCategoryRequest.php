<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\BaseRequest;

class CreateCategoryRequest extends BaseRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image'
        ];
    }
}
