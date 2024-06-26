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
        // Validations in model
        Product::validate($request);

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
            $newProduct->setImage("default.jpeg");
        }

        $newProduct->save();
        return back();
    }

    public function delete($id)
    {
        Product::destroy($id);
        return back();
    }

    public function edit($id)
    {
        $viewData = [];
        $viewData["title"] = "Admin Page - Edit Product - Online Store";
        $viewData["product"] = Product::findOrFail($id);
        return view("admin.product.edit")->with("viewData", $viewData);
    }

    public function update(Request $request, $id)
    {
        // Validations in model
        Product::validate($request);

        $product = Product::findOrFail($id);
        $product->setName($request->input('name'));
        $product->setDescription($request->input('description'));
        $product->setPrice($request->input('price'));

        if ($request->hasFile('image')) {
            $imageName = $product->getId() . "." . $request->file('image')->extension();
            Storage::disk('public')->put(
                $imageName,
                file_get_contents($request->file('image')->getRealPath())
            );
            $product->setImage($imageName);
        }

        $product->save();
        return redirect()->route('admin.product.index');
    }
}
