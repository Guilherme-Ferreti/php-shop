<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\View\View;

class HomeController
{
    public function index(): View
    {
        $products = Product::randomOrder(6);

        $productsCount = Product::count();

        return View::make('dashboard.html', compact('products', 'productsCount'));
    }
}
