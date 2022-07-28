<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\StoreProductAction;
use App\Models\Category;
use App\Models\Product;
use App\Validators\StoreProductValidator;
use App\View\View;

class ProductController
{
    public function index(): View
    {
        $products = Product::all(orderDirection: 'desc');

        return View::make('products/index.html', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::all(orderBy: 'name');

        return View::make('products/create.html', compact('categories'));
    }

    public function store(): void
    {
        $attributes = (new StoreProductValidator())->validate($_POST);

        $action = new StoreProductAction();

        $action($attributes);

        redirect('/products');
    }
}
