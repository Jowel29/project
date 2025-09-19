<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $image_url = $this->image
            ? (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')
                ? $this->image
                : config('app.url').'/'.ltrim($this->image, '/'))
            : null;

        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $image_url,
        ];

        return $data;
    }
}
