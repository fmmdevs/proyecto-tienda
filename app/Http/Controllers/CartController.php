<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $total = 0;
        $productsInCart = [];

        $productsInSession = $request->session()->get("products");

        if ($productsInSession) {
            $productsInCart = Product::findMany(array_keys($productsInSession));
            $total = Product::sumPricesByQuantities($productsInCart, $productsInSession);
        }

        $viewData = [];
        $viewData["title"] = "Cart - Online Store";
        $viewData["subtitle"] = "Shopping Cart";
        $viewData["total"] = $total;
        $viewData["products"] = $productsInCart;
        return view("cart.index")->with("viewData", $viewData);
    }

    public function add(Request $request, $id)
    {
        $products = $request->session()->get("products");
        $products[$id] = $request->input("quantity");
        $request->session()->put("products", $products);

        return redirect()->route("cart.index");
    }

    public function delete(Request $request)
    {
        $request->session()->forget("products");
        return back();
    }

    public function purchase(Request $request)
    {
        $productsInSession = $request->session()->get("products");
        if ($productsInSession) {
            $userId = Auth::user()->getId();
            $order = new Order();
            $order->setUserId($userId);
            $order->setTotal(0);
            $order->save();

            $total = 0;
            $productsInCart = Product::findMany(array_keys($productsInSession));
            //Recorremos los productos que tenemos en el carrito
            foreach ($productsInCart as $product) {
                // $productsInSession es un array asociativo cuya
                // clave es la id y el valor es la cantidad de ese producto
                $quantity = $productsInSession[$product->getId()];
                // Por cada producto que tengamos en el carrito, creamos un nuevo item
                $item = new Item();
                $item->setQuantity($quantity);
                $item->setPrice($product->getPrice());
                $item->setProductId($product->getId());
                $item->setOrderId($order->getId());
                $item->save();
                // Vamos calculando el total
                $total = $total + ($product->getPrice() * $quantity);
            }
            // Añadimos el total calculado a la orden
            $order->setTotal($total);
            $order->save();
            // Eliminamos los productos de la sesion
            $request->session()->forget('products');

            $viewData = [];
            $viewData['title'] = "Purchase - Online Store";
            $viewData['subtitle'] = "Purchase Status";
            $viewData["order"] = $order;
            return view('cart.purchase')->with('viewData', $viewData);
        } else {
            return redirect()->route('cart.index');
        }
    }
}
