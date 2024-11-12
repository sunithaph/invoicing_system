<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();

        $cartItems = CartItem::where('user_id', $user->id)->get();
        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });

        return view('cart-items.index', compact('cartItems', 'totalPrice'));
    }

    // Show the form to add a new product to the cart
    public function create()
    {
        $products = Product::all();
        return view('cart-items.create', compact('products'));
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
    
        $product = Product::findOrFail($request->product_id);
        $availableStock = $product->quantity;
    
        $user = Auth::user();
        $cartItem = CartItem::where('user_id', $user->id)
                            ->where('product_id', $request->product_id)
                            ->first();
    
        $existingCartQuantity = $cartItem ? $cartItem->quantity : 0;
        $newQuantity = $existingCartQuantity + $request->quantity;    
        
        if ($newQuantity > $availableStock) {
            return redirect()->back()->withErrors([
                'quantity' => 'The total quantity for this item exceeds available stock. Please Check your cart.',
            ]);
        }
    
        if ($cartItem) {
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }
    
        return redirect()->route('cart-items.index')->with('success', 'Product added to cart.');
    }
    

    // Show the form to edit a cart item
    public function edit($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $products = Product::all();
        return view('cart-items.edit', compact('cartItem', 'products'));
    }

    // Update the specified cart item
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::findOrFail($id);
        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('cart-items.index')->with('success', 'Cart item updated.');
    }

    // Remove the specified cart item from storage
    public function destroy($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return redirect()->route('cart-items.index')->with('success', 'Cart item removed.');
    }
}
