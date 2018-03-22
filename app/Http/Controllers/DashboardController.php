<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class DashboardController extends Controller
{
    public function index () {
        $data = Product::get();
        return view('pages/product',['products'=>$data]);
    }
    
}
