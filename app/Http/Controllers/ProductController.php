<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // public static $products = [
    //     // Cada uno de los elementos del array $products es una declaracion de un array asociativo
    //     ["id" => "1", "name" => "Camiseta-1", "description" => "Best Camiseta-1", "image" => "camiseta-1.jpeg", "price" => "1000"],
    //     ["id" => "2", "name" => "Camiseta-2", "description" => "Best Camiseta-2", "image" => "camiseta-2.jpeg", "price" => "100"],
    //     ["id" => "3", "name" => "Camiseta-3", "description" => "Best Camiseta-3", "image" => "camiseta-3.jpeg", "price" => "900"],
    //     ["id" => "4", "name" => "Camiseta-4", "description" => "Best Camiseta-4", "image" => "camiseta-4.jpeg", "price" => "300"]
    // ];

    public function index()
    {
        $viewData = [];
        $viewData["title"] = "Products - Online Store";
        $viewData["subtitle"] = "List of products";
        $viewData["products"] = Product::all();
        return view('product.index')->with("viewData", $viewData);
    }

    public function show($id)
    {
        $viewData = [];
        $product = Product::findOrFail($id);
        $viewData["title"] = $product->getName() . " - Online Store";
        $viewData["subtitle"] = $product->getName() . " - Product information";
        $viewData["product"] = $product;
        return view('product.show')->with("viewData", $viewData);
    }
}
