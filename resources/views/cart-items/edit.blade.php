@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Cart Item</h1>

    <form action="{{ route('cart-items.update', $cartItem->id) }}" method="POST" onsubmit="return checkQuantity()">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="product" class="form-label">Product</label>
            <input type="text" class="form-control" value="{{ $cartItem->product->name }}" readonly>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="{{ $cartItem->quantity }}" required>
            <small class="text-muted">Available stock: {{ $cartItem->product->quantity }}</small>
        </div>

        <button type="submit" class="btn btn-primary">Update Cart</button>
    </form>
</div>

<script>
    function checkQuantity() {
        const availableStock = {{ $cartItem->product->quantity }};
        const quantity = document.getElementById('quantity').value;

        if (parseInt(quantity) > availableStock) {
            alert('The quantity exceeds the available stock. Please adjust the quantity.');
            return false;
        }
        return true;
    }
</script>
@endsection

