<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index()
    {
        $viewData = [];
        $viewData['title'] = "Admin Page - Products - Online Store";
        $viewData['products'] = Product::all();
        return view('admin.product.index')->with('viewData', $viewData);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|max:255",
            "description" => "required",
            "price" => "required|decimal:0,2|gt:0",
            "image" => "image",
        ]);

        $newProduct = new Product();
        $newProduct->setName($request->input('name'));
        $newProduct->setDescription(($request->input('description')));
        $newProduct->setPrice($request->input('price'));
        // We save here to initialize id atribute
        $newProduct->save();


        if ($request->hasFile('image')) {
            $imageName = $newProduct->getId() . "." . $request->file('image')->extension();
            Storage::disk('public')->put($imageName, file_get_contents($request->file('image')->getRealPath()));
            $newProduct->setImage($imageName);
        } else {
            $newProduct->setImage("europe-trees.jpeg");
        }

        $newProduct->save();
        return back();
    }
}
