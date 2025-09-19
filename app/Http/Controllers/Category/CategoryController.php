<?php

namespace App\Http\Controllers\Category;

use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\SearchCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService) {}

    public function index(Request $request): JsonResponse
    {
        return $this->categoryService->getAllCategories($request);
    }

    /************************************** */
    public function searchByFilters(SearchCategoryRequest $request): JsonResponse
    {
        return $this->categoryService->searchByFilters($request);
    }
    /******************************** */

    public function createCategory(CreateCategoryRequest $request): JsonResponse
    {
        return $this->categoryService->createCategory($request->validated(), $request);
    }

    /************************************************* */
    public function getCategoryById(Category $category): JsonResponse
    {
        return $this->categoryService->getCategoryById($category);
    }
    /************************************************************ */

    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        return $this->categoryService->updateCategory($request->validated(), $category);
    }

    /************************************************** */
    public function destroy(Category $category): JsonResponse
    {
        return $this->categoryService->deleteCategory($category);
    }
}
