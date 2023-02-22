<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function category()
    {
        return view('pages.category');
    }

    public function catalogue()
    {
        return view('pages.catalogue');
    }

    public function product()
    {
        return view('pages.product');
    }

    public function show(Category $category)
    {
        return view('pages.show', compact('category'));
    }

    public function cart()
    {
        return view('pages.cart');
    }
}
