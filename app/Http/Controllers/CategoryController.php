<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\RouteNotFoundException;
use App\Models\Category;
use App\Validators\StoreCategoryValidator;
use App\View\View;

class CategoryController
{
    public function index(): View
    {
        $categories = Category::all(orderDirection: 'desc');

        return View::make('categories/index.html', compact('categories'));
    }

    public function create(): View
    {
        return View::make('categories/create.html');
    }

    public function store()
    {
        $attributes = (new StoreCategoryValidator())->validate($_POST);

        $category = new Category($attributes);

        $category->insert();

        redirect('/categories');
    }

    public function edit(string $id): View
    {
        if (! $category = Category::find((int) $id)) {
            throw new RouteNotFoundException();
        }

        return View::make('categories/edit.html', compact('category'));
    }

    public function update(string $id)
    {
        if (! $category = Category::find((int) $id)) {
            throw new RouteNotFoundException();
        }

        dd($category);
    }
}
