<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;

class ProductController extends BaseController
{
    public function index()
    {
        $products = Product::all();

        return $this->sendResponse($products, 'Products retrieved successfully.');
    }
}
