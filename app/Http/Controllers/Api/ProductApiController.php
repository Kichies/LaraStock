<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response; 

class ProductApiController extends Controller
{

    public function index()
    {
        $products = Product::all();

        return Response::json([
            'status' => 'success',
            'message' => 'Data inventaris berhasil diambil',
            'data' => $products
        ], 200);
    }
    
}