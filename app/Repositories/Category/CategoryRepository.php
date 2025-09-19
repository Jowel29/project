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
        return (new Category)->getAllCategories($items, $column, $direction);
    }

    /**************** */
    public function getCategoryByFilters(SearchCategoryRequest $request, $items)
    {
        $query = Category::query();
        if ($request->has('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        return $query->paginate($items, ['*']);
    }

    /********************** */
    public function createCategory(array $data)
    {
        return $this->lockForCreate(function () use ($data) {
            return Category::create($data);
        });
    }

    /********************* */
    public function updateCategory(array $data, Category $category)
    {
        return $this->lockForUpdate(Category::class, $category->id, function ($locked_category) use ($data) {
            $locked_category->update($data);

            return $locked_category;
        });
    }

    /*************************** */
    public function deleteCategory(Category $category)
    {
        return $this->lockForDelete(Category::class, $category->id, function ($locked_category) {
            $locked_category->delete();

            return $locked_category;
        });
    }
}
