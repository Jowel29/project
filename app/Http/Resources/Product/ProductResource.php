<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $imageUrl = $this->image
            ? (str_starts_with($this->image, 'https://') || str_starts_with($this->image, 'http://')
                ? $this->image
                : config('app.url').'/'.ltrim($this->image, '/'))
            : null;

        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $imageUrl,
            'description' => $this->description,
            'price' => $this->price,
            'category'=>$this->category->name,
        ];
        if ($request->routeIs('products.index')) {
            unset($data['description']);
        }

        return $data;
    }
}
