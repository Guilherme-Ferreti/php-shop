<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\View\View;

class ProductController
{
    public function index()
    {
        $products = Product::all(orderDirection: 'desc');

        return View::make('products/index.html', compact('products'));
    }

    public function create()
    {
        $categories = Category::all(orderBy: 'name');

        return View::make('products/create.html', compact('categories'));
    }
}
