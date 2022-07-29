<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\StoreProductAction;
use App\Actions\UpdateProductAction;
use App\Exceptions\RouteNotFoundException;
use App\Models\Category;
use App\Models\Product;
use App\Validators\StoreProductValidator;
use App\Validators\UpdateProductValidator;
use App\View\View;

class ProductController
{
    public function index(): View
    {
        $products = Product::all(orderDirection: 'desc');

        $products->loadCategories();

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

    public function edit(string $id)
    {
        if (! $product = Product::find((int) $id)) {
            throw new RouteNotFoundException();
        }

        $categories = Category::all(orderBy: 'name');

        $product->loadCategories();

        return View::make('products/edit.html', compact('product', 'categories'));
    }

    public function update(string $id)
    {
        if (! $product = Product::find((int) $id)) {
            throw new RouteNotFoundException();
        }

        $attributes = (new UpdateProductValidator())->ignore($product)->validate($_POST);

        $action = new UpdateProductAction();

        $action($product, $attributes);

        redirect('/products');
    }

    public function destroy(string $id)
    {
        if (! $product = Product::find((int) $id)) {
            throw new RouteNotFoundException();
        }

        $product->delete();

        redirect('/products');
    }
}
