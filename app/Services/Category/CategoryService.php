<?php

namespace App\Services\Category;

use App\Helpers\ResponseHelper;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\SearchCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category\Category;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class CategoryService
{

    public function __construct(protected CategoryRepository $categoryRepository) {}

    public function getAllCategories(Request $request)
    {
        $items = $request->query('items', 20);
        $column = $request->query('column', 'name');
        $direction = $request->query('direction', 'desc');
        // **
        $valid_directions = ['asc', 'desc'];
        $valid_columns = ['name'];
        //
        if (! in_array($direction, $valid_directions) || ! in_array($column, $valid_columns)) {
            return ResponseHelper::jsonResponse(
                [],
                'Invalid sort column or direction. Allowed columns: ' . implode(', ', $valid_columns) .
                    '. Allowed directions: ' . implode(', ', $valid_directions) . '.',
                400,
                false

            );
        }
        // **
        $categories = $this->categoryRepository->getAll($items, $column, $direction);
        $data = [
            'categories' => CategoryResource::collection($categories),
            'total_pages' => $categories->lastPage(),
            'current_page' => $categories->currentPage(),
            'hasMorePages' => $categories->hasMorePages(),
        ];
        return ResponseHelper::jsonResponse($data, ' categories retrieved successfully');
    }
    /***************************************** */
    public function searchByFilters(SearchCategoryRequest $request)
    {
        $items = $request->query('items', 10);
        $categories = $this->categoryRepository->getCategoryByFilters($request, $items);

        if ($categories->isEmpty()) {
            return ResponseHelper::jsonResponse([], 'not found the category', 404);
        }
        $data = [
            'categouries' => CategoryResource::collection($categories),
            'total_pages' => $categories->lastPage(),
            'current_page' => $categories->currentPage(),
            'hasMorePages' => $categories->hasMorePages(),

        ];
        return ResponseHelper::jsonResponse($data, 'category retrieved successfully');
    }
    /****************************** */
    public function getCategoryById(Category $category)
    {
        $data = [
            'categories' => CategoryResource::collection($category)
        ];
        return ResponseHelper::jsonResponse($data, 'details retrieved successfully');
    }
    /************************************ */
    public function createCategory(array $data, CreateCategoryRequest $request): JsonResponse
    {
        $data['image'] = $request->hasFile('image') ? $request->file('image')->storeAs('images', $request->file('image')->hashName(), 'local_public') : null;
        $categories = $this->categoryRepository->createCategory($data);
        $data = [
            'Categories' => CategoryResource::make($categories)
        ];
        return ResponseHelper::jsonResponse($data, 'category created successfully!', 201);
    }
    /******************************* */
    public function updateCategory(array $data, Category $category)
    {
        if (isset($data['image'])) {
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }
            $path = $data['image']->storeAs('images', $data['image']->hashName(), 'local_public');
            $data['image'] = $path;
        }
        // **
        $categories = $this->categoryRepository->updateCategory($data, $category);
        $data = [
            'categories' => CategoryResource::make($categories)
        ];
        return ResponseHelper::jsonResponse($data, 'category updated successfully!');
    }

    /**************************************************** */
    public function deleteCategory(Category $category)
    {
        $categories = $this->categoryRepository->deleteCategory($category);
        return ResponseHelper::jsonResponse([], 'category deleted successfully');
    }
}
