<?php

namespace App\Services\Product;

use App\Helpers\ResponseHelper;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\SearchProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product\Product;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductService
{
    public function __construct(protected ProductRepository $productRepository) {}

    public function getAllProducts(Request $request)
    {
        $items = $request->query('items', 20);
        $column = $request->query('column', 'name');
        $direction = $request->query('direction', 'asc');
        $validColumns = ['name', 'price', 'amount', 'description'];
        $validDirections = ['asc', 'desc'];

        if (! in_array($column, $validColumns) || ! in_array($direction, $validDirections)) {
            return ResponseHelper::jsonResponse(
                [],
                'Invalid sort column or direction. Allowed columns: '.implode(', ', $validColumns).
                '. Allowed directions: '.implode(', ', $validDirections).'.',
                400,
                false
            );
        }
        $products = $this->productRepository->getAll($items, $column, $direction);

        $data = [
            'Products' => ProductResource::collection($products),
            'total_pages' => $products->lastPage(),
            'current_page' => $products->currentPage(),
            'hasMorePages' => $products->hasMorePages(),
        ];

        return ResponseHelper::jsonResponse($data, 'Products retrieved successfully');
    }

    public function searchByFilters(SearchProductRequest $request)
    {
        $items = $request->query('items', 10);
        $products = $this->productRepository->getProductsByFilters($request, $items);

        if ($products->isEmpty()) {
            return ResponseHelper::jsonResponse([], 'No products found for the given filters.', 404);
        }
        $data = [
            'Products' => ProductResource::collection($products),
            'total_pages' => $products->lastPage(),
            'current_page' => $products->currentPage(),
            'hasMorePages' => $products->hasMorePages(),
        ];

        return ResponseHelper::jsonResponse($data, 'Products retrieved successfully');
    }

    public function getProductById(Product $product)
    {
        $data = ['product' => ProductResource::make($product)];

        return ResponseHelper::jsonResponse($data, 'Product retrieved successfully!');
    }

    public function createProduct(array $data, CreateProductRequest $request): JsonResponse
    {
        $data['image'] = $request->hasFile('image') ? $request->file('image')->storeAs('images', $request->file('image')->hashName(), 'local_public') : null;
        $product = $this->productRepository->create($data);
        $data = [
            'Product' => ProductResource::make($product),
        ];

        return ResponseHelper::jsonResponse($data, 'Product created successfully!', 201);

    }

    public function updateProduct(Product $product, array $data)
    {
        if (isset($data['image'])) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $path = $data['image']->storeAs('images', $data['image']->hashName(), 'local_public');
            $data['image'] = $path;
        }
        $product = $this->productRepository->update($product, $data);
        $data = [
            'Product' => ProductResource::make($product),
        ];

        return ResponseHelper::jsonResponse($data, 'Product updated successfully!');
    }

    public function deleteProduct(Product $product)
    {
        $this->productRepository->delete($product);

        return ResponseHelper::jsonResponse([], 'Product deleted successfully!');
    }
}
