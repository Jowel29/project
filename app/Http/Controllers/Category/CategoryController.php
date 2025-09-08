<?php

namespace App\Http\Controllers\Category;

use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\SearchCategoryRequest;
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
    public function show(Category $category)
    {
        return $this->categoryService->getCategoryById();
    }




    public function update(Request $request, Category $category)
    {
        //
    }

    public function destroy(Category $category)
    {
        //
    }
}
