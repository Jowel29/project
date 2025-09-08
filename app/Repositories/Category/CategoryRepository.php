<?php

namespace App\Repositories\Category;

use App\Http\Requests\Category\SearchCategoryRequest;
use App\Models\Category\Category;
use App\Traits\Lockable;

class CategoryRepository
{
    use Lockable;
    public function getAll($items, $column, $direction)
    {
        return (new Category)->getAllCategoris($items, $column, $direction);
    }

    public function filterCategoryByName(SearchCategoryRequest $request, $items) {}
}
