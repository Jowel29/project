<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    public static function getAllProducts($items, $column, $direction)
    {
        return self::orderBy($column, $direction)->paginate($items);
    }
}
