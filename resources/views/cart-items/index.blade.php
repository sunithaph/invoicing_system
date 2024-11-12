@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your Cart</h2>

    @if ($cartItems->isEmpty())
        <div class="alert alert-info">
            Your cart is empty. 
            <a href="{{ route('cart-items.create') }}" class="btn btn-primary btn-sm">Add Products to Cart</a>
        </div>
    @else
    <div class="alert alert-info">
        <a href="{{ route('cart-items.create') }}" class="btn btn-primary btn-sm">Add Products to Cart</a>
    </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $cartItem)
                    <tr>
                        <td>{{ $cartItem->product->name }}</td>
                        <td>{{ $cartItem->quantity }}</td>
                        <td>{{ $cartItem->product->price }}</td>
                        <td>{{ $cartItem->quantity * $cartItem->product->price }}</td>
                        <td>
                            <a href="{{ route('cart-items.edit', $cartItem->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form action="{{ route('cart-items.destroy', $cartItem->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-end">
            <h4>Total Price: {{ $totalPrice }}</h4>
        </div>

        <a href="{{ route('invoices.create') }}" class="btn btn-success mt-3">Proceed to Invoice</a>
    @endif
</div>
@endsection
