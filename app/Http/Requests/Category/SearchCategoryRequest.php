<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\BaseRequest;

class SearchCategoryRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
        ];
    }
}
