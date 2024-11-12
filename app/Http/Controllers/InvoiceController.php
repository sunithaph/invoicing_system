<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        if (Auth::user()->is_admin) {
            $invoices = Invoice::with('user')->get();
        } else {
            $invoices = Invoice::with('user')->where('user_id', Auth::id())->get();
        }
        
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $user = auth()->user();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });

        if ($totalPrice >= 1500) {
            $discountPercentage = 15;
        } elseif ($totalPrice >= 1000) {
            $discountPercentage = 10;
        } elseif ($totalPrice >= 500) {
            $discountPercentage = 5;
        } else {
            $discountPercentage = 0;
        }

        $discount = ($totalPrice * $discountPercentage) / 100;
        $discountedPrice = $totalPrice - $discount;
        $tax = $discountedPrice * 0.07; 
        $finalTotal = $discountedPrice + $tax;
        
        return view('invoices.create', compact(
            'cartItems', 'totalPrice', 'discount', 'discountPercentage', 'discountedPrice', 'tax', 'finalTotal'
        ));
    }



    public function store(Request $request)
    {
    $request->validate([
        'payment_method' => 'required|string',
    ]);

    $user = auth()->user();
    if (!$user) {
        return redirect()->route('login')->with('error', 'Please log in to create an invoice.');
    }
    
    $cartItems = CartItem::where('user_id', $user->id)->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('cart-items.index')->with('error', 'Your cart is empty.');
    }

    $totalAmount = $cartItems->sum(function ($cartItem) {
        return $cartItem->product->price * $cartItem->quantity;
    });
    
    $discountRate = 0;
    if ($totalAmount >= 1500) {
        $discountRate = 0.15;
    } elseif ($totalAmount >= 1000) {
        $discountRate = 0.10;
    } elseif ($totalAmount >= 500) {
        $discountRate = 0.05;
    }
    $discountAmount = $totalAmount * $discountRate;

    $subtotalAfterDiscount = $totalAmount - $discountAmount;
    $taxRate = 0.07;
    $taxAmount = $subtotalAfterDiscount * $taxRate;
    
    $finalTotal = $subtotalAfterDiscount + $taxAmount;

    $invoice = Invoice::create([
        'user_id' => $user->id, 
        'subtotal' => $totalAmount,
        'tax_percentage' => $taxRate * 100, 
        'tax' => $taxAmount,
        'discount_percentage' => $discountRate * 100, 
        'discount' => $discountAmount,
        'total_amount' => $finalTotal,
        'payment_method' => $request->payment_method,
    ]);

    foreach ($cartItems as $cartItem) {
        $invoice->invoiceItems()->create([
            'product_id' => $cartItem->product_id,
            'quantity' => $cartItem->quantity,
        ]);
    }

    // Clear the user's cart
    CartItem::where('user_id', $user->id)->delete();

    return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }



    public function show($id)
    {
        $invoice = Invoice::with(['user', 'invoiceItems.product'])->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
