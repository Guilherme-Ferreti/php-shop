<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\View\View;

class CategoryController
{
    public function index()
    {
        $categories = Category::all(orderDirection: 'desc');

        return View::make('categories/index.html', compact('categories'));
    }
}
