<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Validators\StoreCategoryValidator;
use App\View\View;

class CategoryController
{
    public function index()
    {
        $categories = Category::all(orderDirection: 'desc');

        return View::make('categories/index.html', compact('categories'));
    }

    public function create()
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
}
