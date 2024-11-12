@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Invoice</h1>

    @if($cartItems->isEmpty())
        <div class="alert alert-warning">Your cart is empty. Please add products to your cart before creating an invoice.</div>
    @else
        <div class="mb-4">
            <h4>Customer Name: {{ Auth::user()->name }}</h4>
            <p>Email: {{ Auth::user()->email }}</p>
        </div>

        <form action="{{ route('invoices.store') }}" method="POST">
            @csrf

            <table class="table table-bordered mb-4">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $cartItem)
                        <tr>
                            <td>{{ $cartItem->product->name }}</td>
                            <td>{{ $cartItem->quantity }}</td>
                            <td>{{ number_format($cartItem->product->price, 2) }}</td>
                            <td>{{ number_format($cartItem->product->price * $cartItem->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
          
            <div class="mb-4">
                <p><strong>Subtotal:</strong> {{ number_format($totalPrice, 2) }}</p>
                
                <p><strong>Discount:</strong> - {{ number_format($discount, 2) }} 
                    <small class="text-muted">({{ $discountPercentage }}% off)</small>
                </p>

                <p><strong>Subtotal after Discount:</strong> {{ number_format($discountedPrice, 2) }}</p>
                <p><strong>Tax (7%):</strong> + {{ number_format($tax, 2) }}</p>
                <h4><strong>Total after Discount & Tax:</strong> {{ number_format($finalTotal, 2) }}</h4>
            </div>

            <div class="mb-4">
                <label for="payment_method" class="form-label">Payment Method</label>
                <select name="payment_method" id="payment_method" class="form-select">
                    <option value="cash">Cash</option>
                    <option value="credit">Credit Card</option>
                    <option value="paypal">PayPal</option>
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Create Invoice</button>
            </div>
        </form>
    @endif
</div>
@endsection
